<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\CafeBooking;
use App\Models\Cafe;

class CafeBookingController extends Controller
{
    public function store(Request $request, $cafeId)
    {
        // Find the cafe by ID
        $cafe = Cafe::find($cafeId);
    
        if (!$cafe) {
            return response()->json(['message' => 'Cafe not found'], 404);
        }
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'appointment_time' => 'required|date_format:Y-m-d H:i:s',
            'number_of_individuals' => 'required|in:1-3,4-6,6-8',
            'payment_method' => 'required|in:cash,wallet,credit/debit/ATM',
        ]);
    
        // Get the authenticated user's ID
        $userId = auth()->id();
    
        // Create the booking record and include the user_id
        $booking = CafeBooking::create(array_merge($validatedData, [
            'cafe_id' => $cafe->id,
            'user_id' => $userId,  // Include the authenticated user's ID
        ]));
    
        // Generate the QR code data as a string
        $qrData = json_encode([
            'full_name' => $booking->full_name,
            'mobile_number' => $booking->mobile_number,
            'appointment_time' => $booking->appointment_time,
            'number_of_individuals' => $booking->number_of_individuals,
            'payment_method' => $booking->payment_method,
            'cafe_name' => $cafe->name,
            'cafe_location' => $cafe->location,
        ]);
    
        // Generate the QR code image
        $qrCode = QrCode::format('png')->size(300)->generate($qrData);
    
        // Generate a file name starting with "cafe" and a unique identifier
        $qrCodeFileName = 'cafe_' . uniqid() . '.png';
    
        // Define the path to store the QR code image in 'public/storage/bookings' folder
        $qrCodePath = 'bookings/' . $qrCodeFileName;
    
        // Store the QR code image in the public storage path
        Storage::disk('public')->put($qrCodePath, $qrCode);
    
        // Save the QR code path to the booking record
        $booking->update(['qr_code_path' => $qrCodePath]);
    
        // Construct the full URL for the QR code
        $qrCodeUrl = url('storage/' . $qrCodePath);
    
        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking,
            'qr_code_url' => $qrCodeUrl
        ], 201);
    }
}
