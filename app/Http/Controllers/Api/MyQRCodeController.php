<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomBooking;
use App\Models\TripBooking;
use Illuminate\Support\Facades\Auth;


class MyQRCodeController extends Controller
{
    public function myQRCodes()
    {
        // Retrieve QR codes for trip bookings
        $tripBookings = TripBooking::where('user_id', Auth::id())
            ->whereNotNull('qr_code_path')
            ->get(['id', 'trip_offer_id', 'qr_code_path']);

        // Retrieve QR codes for room bookings
        $roomBookings = RoomBooking::where('user_id', Auth::id())
            ->whereNotNull('qr_code_path')
            ->get(['id', 'room_id', 'qr_code_path']);

        // Prepare the response
        return response()->json([
            'message' => 'QR codes retrieved successfully',
            'trip_bookings' => $tripBookings,
            'room_bookings' => $roomBookings,
        ], 200);
    }


    public function destroy($id, $type)
    {
        // Check if the type is valid
        if (!in_array($type, ['trip', 'room'])) {
            return response()->json([
                'message' => 'Invalid type specified'
            ], 400);
        }

        // Determine the model to use based on the type
        $model = $type === 'trip' ? TripBooking::class : RoomBooking::class;

        // Find the booking by ID
        $booking = $model::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        // Check if booking exists
        if (!$booking) {
            return response()->json([
                'message' => 'Booking not found'
            ], 404);
        }

        // Delete the QR code file if it exists
        if ($booking->qr_code_path && File::exists(public_path('storage/' . $booking->qr_code_path))) {
            File::delete(public_path('storage/' . $booking->qr_code_path));
        }

        // Delete the booking
        $booking->delete();

        // Return success response
        return response()->json([
            'message' => 'Booking and QR code deleted successfully'
        ], 200);
    }

}
