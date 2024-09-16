<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OfferTrip;
use App\Models\TripBooking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage; 
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Validation\ValidationException;

class TripBookingController extends Controller
{
    public function store(Request $request, OfferTrip $trip_offer)
    {
        // Validate request data
        try {
            $validated = $request->validate([
                'individuals_count' => 'required|integer|min:1',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        // Calculate total cost
        $totalCost = $validated['individuals_count'] * $trip_offer->total_cost;

        // Create a TripBooking
        $booking = TripBooking::create([
            'user_id' => Auth::id(),
            'trip_offer_id' => $trip_offer->id,
            'individuals_count' => $validated['individuals_count'],
            'total_cost' => $totalCost,
        ]);

        // Generate QR Code
        try {
            $this->generateQRCode($booking);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to generate QR code',
                'error' => $e->getMessage(),
            ], 500);
        }

        // Return successful response
        return response()->json([
            'message' => 'Trip booked successfully',
            'booking' => $booking,
        ], 201);
    }

    private function generateQRCode($booking)
    {
        // Prepare the QR code data
        $qrData = json_encode([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'trip_offer_id' => $booking->trip_offer_id,
        ]);

        // Directory to save the QR code image
        $qrCodeDir = storage_path('app/public/qr_codes/');
        if (!File::exists($qrCodeDir)) {
            File::makeDirectory($qrCodeDir, 0755, true);
        }

        // Define the QR code file path
        $qrCodePath = 'qr_codes/tripbook_' . $booking->id . '.png';

        // Generate the QR code and save it to the specified path
        QrCode::format('png')
            ->size(300)
            ->generate($qrData, $qrCodeDir . 'tripbook_' . $booking->id . '.png');

        // Save only the file path in the database
        $booking->qr_code_path = $qrCodePath;
        $booking->save();
    }

    public function show(TripBooking $trip_booking)
    {
        // Return the booking details
        return response()->json([
            'booking' => $trip_booking,
        ]);
    }

    public function destroy(TripBooking $trip_booking)
    {
        // Delete the QR code file if it exists
        $qrCodePath = public_path('storage/' . $trip_booking->qr_code_path);
        if (File::exists($qrCodePath)) {
            try {
                File::delete($qrCodePath);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Failed to delete QR code file',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        // Delete the booking record
        $trip_booking->delete();

        // Return successful response
        return response()->json([
            'message' => 'Booking deleted successfully',
        ], 200);
    }
}
