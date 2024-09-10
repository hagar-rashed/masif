<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OfferBookingController extends Controller
{
    public function store(Request $request, OfferTrip $trip_offer)
{
    $validated = $request->validate([
        'passenger_count' => 'required|integer|min:1',
    ]);

    // Create a booking
    $booking = Booking::create([
        'user_id' => auth()->id(),
        'trip_offer_id' => $trip_offer->id,
        'passenger_count' => $validated['passenger_count'],
    ]);

    // Generate QR code
    $qrCodePath = $this->generateQRCode($booking);
    $booking->update(['qr_code_path' => $qrCodePath]);

    return response()->json([
        'message' => 'Booking successful',
        'booking' => $booking,
        'qr_code' => url($qrCodePath)
    ]);
}

private function generateQRCode($booking)
{
    $qrData = json_encode([
        'booking_id' => $booking->id,
        'user_id' => $booking->user_id,
        'trip_offer_id' => $booking->trip_offer_id,
    ]);

    $qrCodePath = 'qrcodes/' . Str::random(10) . '.png';
    \QrCode::format('png')->size(300)->generate($qrData, storage_path('app/public/' . $qrCodePath));

    return 'storage/' . $qrCodePath;
}

}