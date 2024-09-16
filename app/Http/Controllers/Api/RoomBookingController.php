<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\RoomAvailability;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Add this line
use Illuminate\Support\Facades\Storage; // To store the QR code file
use Carbon\Carbon;

class RoomBookingController extends Controller
{
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // Check if the room is available for the requested dates
        $room = Room::findOrFail($request->room_id);
        $availability = RoomAvailability::where('room_id', $room->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->from_date, $request->to_date])
                      ->orWhereBetween('end_date', [$request->from_date, $request->to_date])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('start_date', '<=', $request->from_date)
                                ->where('end_date', '>=', $request->to_date);
                      });
            })
            ->get();
    
        if ($availability->isEmpty()) {
            return response()->json(['message' => 'Room is not available for the selected dates'], 400);
        }
    
        // Update availability to remove the booked dates
        foreach ($availability as $available) {
            // If the entire availability period is booked
            if ($available->start_date <= $request->from_date && $available->end_date >= $request->to_date) {
                $available->delete();
            }
            // If only a portion of the availability is booked (before or after the booked dates)
            else {
                if ($available->start_date < $request->from_date) {
                    $available->end_date = $request->from_date->subDay(); // Adjust the end date
                    $available->save();
                } elseif ($available->end_date > $request->to_date) {
                    $available->start_date = $request->to_date->addDay(); // Adjust the start date
                    $available->save();
                }
            }
        }
    
        // Calculate number of nights (difference in days between from_date and to_date)
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date);
        $numberOfNights = $fromDate->diffInDays($toDate) + 1;
    
        // Calculate total price
        $totalPrice = $numberOfNights * $room->night_price;
    
        // Store the booking
        $booking = RoomBooking::create([
            'room_id' => $room->id,
            'user_id' => auth()->id(),
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'number_of_nights' => $numberOfNights,
            'original_price' => $room->night_price,
            'total_price' => $totalPrice,
        ]);
    
        // Generate a QR code with booking details
        $qrData = 'Booking ID: ' . $booking->id . ', Room: ' . $room->name . ', Dates: ' . $request->from_date . ' to ' . $request->to_date;
        $qrCode = QrCode::format('png')->size(300)->generate($qrData);
    
        // Store the QR code image in the public directory
        $qrCodePath = 'qrcodes/booking-' . $booking->id . '.png';
        Storage::disk('public')->put($qrCodePath, $qrCode);
    
        // Save the QR code path in the booking record
        $booking->qr_code_path = $qrCodePath;
        $booking->save();
    
        return response()->json([
            'message' => 'Room booked successfully',
            'booking' => $booking,
            'qr_code_url' => asset('storage/' . $qrCodePath) // Return the QR code URL in the response
        ], 201);
    }
    

    // Show the booking details
    public function show($id)
    {
        $booking = RoomBooking::with('room', 'user')->findOrFail($id);
        return response()->json($booking, 200);
    }

    // Cancel the booking
    public function destroy($id)
    {
        $booking = RoomBooking::findOrFail($id);
        $booking->delete();

        return response()->json(['message' => 'Booking cancelled successfully'], 200);
    }
}
