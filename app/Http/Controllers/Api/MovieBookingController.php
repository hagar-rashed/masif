<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\MovieBooking;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;


class MovieBookingController extends Controller
{
    // public function store(Request $request, Movie $movie)
    // {
    //     // Validate request data
    //     $validated = $request->validate([
    //         'adult_tickets' => 'required|integer|min:0',
    //         'child_tickets' => 'required|integer|min:0',
    //         'hall' => 'required|string',
    //         'seats' => 'required|string',
    //         'booking_date_time' => 'required|date',
    //     ]);

    //     // Fetch movie prices
    //     $adultPrice = $movie->adult_price;
    //     $childPrice = $movie->child_price;

    //     // Calculate total cost
    //     $numberOfAdultTickets = $validated['adult_tickets'];
    //     $numberOfChildTickets = $validated['child_tickets'];

    //     $totalCost = ($numberOfAdultTickets * $adultPrice) + ($numberOfChildTickets * $childPrice);

    //     // Create a MovieBooking
    //     $booking = MovieBooking::create([
    //         'user_id' => Auth::id(),
    //         'movie_id' => $movie->id,
    //         'adult_tickets' => $numberOfAdultTickets,
    //         'child_tickets' => $numberOfChildTickets,
    //         'hall' => $validated['hall'],
    //         'seats' => $validated['seats'],
    //         'booking_date_time' => $validated['booking_date_time'],
    //         'adult_price' => $adultPrice, // Store adult_price
    //         'child_price' => $childPrice, // Store child_price
    //         'total_price' => $totalCost,
    //     ]);

    //     // Generate QR Code
    //     $this->generateQRCode($booking);

    //     // Return successful response
    //     return response()->json([
    //         'message' => 'Movie booked successfully',
    //         'booking' => $booking,
    //         'pricing_details' => [
    //             'number_of_adult_tickets' => $numberOfAdultTickets,
    //             'price_per_adult' => $adultPrice,
    //             'number_of_child_tickets' => $numberOfChildTickets,
    //             'price_per_child' => $childPrice,
    //             'total_price' => $totalCost
    //         ]
    //     ], 201);
    // }

    // Method to generate QR code for the booking
    // protected function generateQRCode(MovieBooking $booking)
    // {
    //     // Generate a QR code using the booking ID or details
    //     $qrCode = QrCode::size(200)->generate(route('movie.bookings.show', $booking->id));

    //     // Save the QR code to the storage
    //     $qrCodePath = 'qrcodes/' . $booking->id . '.png';
    //     \Storage::disk('public')->put($qrCodePath, $qrCode);

    //     // Update the booking with the QR code path
    //     $booking->update([
    //         'qr_code' => $qrCodePath,
    //     ]);
    // }




    public function store(Request $request, Movie $movie)
    {
        // Validate request data
        $validated = $request->validate([
            'adult_tickets' => 'required|integer|min:0',
            'child_tickets' => 'required|integer|min:0',
            'hall' => 'required|string',
            'seats' => 'required|string',
            'booking_date_time' => 'required|date',
        ]);

      // Fetch movie prices
      $adultPrice = $movie->adult_price;
      $childPrice = $movie->child_price;

      // Calculate total cost
      $numberOfAdultTickets = $validated['adult_tickets'];
      $numberOfChildTickets = $validated['child_tickets'];

      $totalCost = ($numberOfAdultTickets * $adultPrice) + ($numberOfChildTickets * $childPrice);

        // Create a TripBooking
        $booking = MovieBooking::create([
            'user_id' => Auth::id(),
            'movie_id' => $movie->id,
            'adult_tickets' => $numberOfAdultTickets,
            'child_tickets' => $numberOfChildTickets,
            'hall' => $validated['hall'],
            'seats' => $validated['seats'],
            'booking_date_time' => $validated['booking_date_time'],
            'adult_price' => $adultPrice, // Store adult_price
            'child_price' => $childPrice, // Store child_price
            'total_price' => $totalCost,
        ]);

        // Generate QR Code
        $this->generateQRCode($booking);

        // Return successful response
        return response()->json([
            'message' => 'Movie booked successfully',
            'booking' => $booking,
            'pricing_details' => [
                'number_of_adult_tickets' => $numberOfAdultTickets,
                'price_per_adult' => $adultPrice,
                'number_of_child_tickets' => $numberOfChildTickets,
                'price_per_child' => $childPrice,
                'total_price' => $totalCost
            ]
        ], 201);
    }

    private function generateQRCode($booking)
    {
        // Prepare the QR code data
        $qrData = json_encode([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'movie_id' => $booking->movie_id,
        ]);

        // Directory to save the QR code image
        $qrCodeDir = public_path('storage/qr_codes/');
        if (!File::exists($qrCodeDir)) {
            File::makeDirectory($qrCodeDir, 0755, true);
        }

        // Define the QR code file path
        $qrCodePath = 'qr_codes/movieBooking_' . $booking->id . '.png';

        // Generate the QR code and save it to the specified path
        QrCode::format('png')
            ->size(300)
            ->generate($qrData, $qrCodeDir . 'movieBooking' . $booking->id . '.png');

        // Save only the file path in the database
        $booking->qr_code = $qrCodePath;
        $booking->save();
    }


    public function show($id)
{
    // Find the booking by ID
    $booking = MovieBooking::find($id);

    // Check if booking exists
    if (!$booking) {
        return response()->json([
            'message' => 'Booking not found'
        ], 404);
    }

    // Return the booking details
    return response()->json([
        'booking' => $booking
    ], 200);
}



public function destroy($id)
{
    // Find the booking by ID
    $booking = MovieBooking::find($id);

    // Check if booking exists
    if (!$booking) {
        return response()->json([
            'message' => 'Booking not found'
        ], 404);
    }

    // Delete the QR code file if it exists
    if ($booking->qr_code && File::exists(public_path('storage/' . $booking->qr_code))) {
        File::delete(public_path('storage/' . $booking->qr_code));
    }

    // Delete the booking
    $booking->delete();

    // Return success response
    return response()->json([
        'message' => 'Booking deleted successfully'
    ], 200);
}

}


