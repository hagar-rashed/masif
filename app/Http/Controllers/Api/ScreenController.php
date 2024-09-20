<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Screen;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Seat;
use App\Models\SeatBooking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode; 
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Auth;


class ScreenController extends Controller
{
    // Get all screens for a specific cinema
    public function getScreens($cinema_id)
    {
        $screens = Screen::where('cinema_id', $cinema_id)
                         ->with('movie')
                         ->get();
        return response()->json($screens);
    }

    // Get all seats for a specific screen (with their availability)
    public function getSeats($screen_id)
    {
        $seats = Seat::where('screen_id', $screen_id)
                     ->get();
        return response()->json($seats);
    }

   


    
    // Create a screen with seats
public function createScreenWithSeats(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'cinema_id' => 'required|exists:cinemas,id',
        'movie_id' => 'required|exists:movies,id',
        'screening_date' => 'required|date',
        'screening_time' => 'required|date_format:H:i',
        'number_of_seats' => 'required|integer|min:1',
        'name' => 'required|string',
        'adult_price' => 'required|integer|min:1',
        'child_price' => 'required|integer|min:1'
    ]);

    // Create the screen
    $screen = Screen::create([
        'cinema_id' => $validated['cinema_id'],
        'movie_id' => $validated['movie_id'],
        'name' => $validated['name'],
        'screening_date' => $validated['screening_date'],
        'screening_time' => $validated['screening_time'],
        'adult_price' => $validated['adult_price'],
        'child_price' => $validated['child_price'],
    ]);

    // Generate seats for the screen
    $this->generateSeats($screen->id, $validated['number_of_seats']);

    // Fetch cinema and movie details
    $cinema = Cinema::find($validated['cinema_id']);
    $movie = Movie::find($validated['movie_id']);

    return response()->json([
        'message' => 'Screen and seats created successfully',
        'screen' => $screen,
        'cinema_name' => $cinema->name,  // Add cinema name
        'movie_name' => $movie->name,    // Add movie name
        'seats' => Seat::where('screen_id', $screen->id)->get()
    ], 201);

}




protected function generateSeats($screenId, $numberOfSeats)
{
    $seatsPerRow = 10; // Number of seats per row
    $totalRows = ceil($numberOfSeats / $seatsPerRow); // Calculate total number of rows

    // Generate seat letters for rows (e.g., A, B, C...)
    $rowLetter = 'A'; // Starting row letter

    for ($row = 1; $row <= $totalRows; $row++) {
        for ($seatInRow = 1; $seatInRow <= $seatsPerRow; $seatInRow++) {
            // Ensure we don't exceed the total number of seats
            if ((($row - 1) * $seatsPerRow) + $seatInRow > $numberOfSeats) {
                break;
            }

            // Seat number format (e.g., A1, A2, B1, B2...)
            $seatNumber = $rowLetter . $seatInRow;

            // Create the seat record
            Seat::create([
                'screen_id' => $screenId,
                'seat_number' => $seatNumber,
                'row_number' => $rowLetter,
                'status' => 'available'  // Default to available
            ]);
        }

        // Move to the next row (next letter)
        $rowLetter++;
    }
}





public function bookSeats(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'seat_numbers' => 'required|array',
        'seat_numbers.*' => 'exists:seats,seat_number',
        'payment_method' => 'required|in:cash,wallet,credit/debit/ATM',
        'number_of_adult_tickets' => 'required|integer|min:0',
        'number_of_child_tickets' => 'nullable|integer|min:0', // Now optional
        'screen_id' => 'required|exists:screens,id', // Include screen_id to get pricing
    ]);

    DB::beginTransaction();
    try {
        // Fetch screen to calculate pricing
        $screen = Screen::find($validated['screen_id']);
        
        if (!$screen) {
            return response()->json(['error' => 'Screen not found'], 404);
        }

        // Fetch seats based on seat numbers, but also check the screen_id matches
        $seats = Seat::whereIn('seat_number', $validated['seat_numbers'])
                     ->where('screen_id', $validated['screen_id']) // Ensure the seats belong to the correct screen
                     ->get();

        if ($seats->count() != count($validated['seat_numbers'])) {
            return response()->json(['error' => 'Some seats are not available or do not belong to this screen'], 400);
        }

        // Check if any seat is already occupied
        if ($seats->contains('status', 'occupied')) {
            return response()->json(['error' => 'Some seats are already occupied'], 400);
        }

        // Ensure child tickets are counted properly (default to 0 if null)
        $numberOfChildTickets = $validated['number_of_child_tickets'] ?? 0;

        // Calculate the total price
        $totalPrice = ($validated['number_of_adult_tickets'] * $screen->adult_price) + 
                      ($numberOfChildTickets * $screen->child_price);

        // Collect seat numbers for the booking
        $seatNumbers = $seats->pluck('seat_number')->implode(',');

        // Create the booking record
        $booking = SeatBooking::create([
            'user_id' => auth()->id(),
            'seat_id' => $seats->first()->id, // Assuming booking is for the first seat in the array
            'seat_numbers' => $seatNumbers,
            'payment_method' => $validated['payment_method'],
            'number_of_adult_tickets' => $validated['number_of_adult_tickets'],
            'number_of_child_tickets' => $numberOfChildTickets,
            'total_price' => $totalPrice, // Dynamically calculated total price
        ]);

        // Generate the QR code for the booking
        $qrCodePath = $this->generateQRCode($booking);

        // Update seat status to occupied
        Seat::whereIn('seat_number', $validated['seat_numbers'])->update(['status' => 'occupied']);

        // Commit the transaction
        DB::commit();

        // Fetch movie details associated with the screen
        $movie = Movie::find($screen->movie_id);

        return response()->json([
            'message' => 'Seats booked successfully',
            'booking' => $booking,
            'total_price' => $totalPrice, // Return calculated total price in response
            'qr_code_url' => asset('storage/' . $qrCodePath), // Return the QR code URL in the response
            'movie' => $movie, // Return movie details
        ], 201);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



    private function generateQRCode($booking)
    {
        // Prepare the QR code data
        $qrData = json_encode([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'seat_numbers' => $booking->seat_numbers,
        ]);

        // Directory to save the QR code image
        $qrCodeDir = storage_path('app/public/qr_codes');
        if (!File::exists($qrCodeDir)) {
            File::makeDirectory($qrCodeDir, 0755, true);
        }

        // Define the QR code file path
        $seatNumber = $booking->seat_numbers; // Assuming the seat number is a unique identifier
        $qrCodePath = 'qr_codes/seat_' . $seatNumber . '.png';

        // Generate the QR code and save it to the specified path
        QrCode::format('png')
            ->size(300)
            ->generate($qrData, $qrCodeDir . '/' . $seatNumber . '.png');

        // Save only the file path in the database
        $booking->qr_code = $qrCodePath;
        $booking->save();

        return $qrCodePath;
    }
}