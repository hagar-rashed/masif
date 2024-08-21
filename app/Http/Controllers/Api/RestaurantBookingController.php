<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use SimpleQRCodeGenerator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

use App\Models\RestaurantBooking;
use App\Models\Restaurant;

class RestaurantBookingController extends Controller
{
    public function store(Request $request, $restaurantId)
    {
        // Find the restaurant by ID
        $restaurant = Restaurant::find($restaurantId);
    
        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'appointment_time' => 'required|date_format:Y-m-d H:i:s',
            'number_of_individuals' => 'required|in:1-3,4-6,6-8',
            'payment_method' => 'required|in:cash_on_restaurant,wallet,credit/debit/ATM',
        ]);
    
        // Create the booking record
        $booking = RestaurantBooking::create(array_merge($validatedData, ['restaurant_id' => $restaurant->id]));
    
        // Generate the QR code data as a string
        $qrData = json_encode([
            'full_name' => $booking->full_name,
            'mobile_number' => $booking->mobile_number,
            'appointment_time' => $booking->appointment_time,
            'number_of_individuals' => $booking->number_of_individuals,
            'payment_method' => $booking->payment_method,
            'restaurant_name' => $restaurant->name,
            'restaurant_location' => $restaurant->location,
        ]);
    
         // Generate the QR code image
         $qrCode = QrCode::format('png')->size(300)->generate($qrData);
    
         // Generate a file name starting with "restaurant" and a unique identifier
         $qrCodeFileName = 'restaurant_' . uniqid() . '.png';
     
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
 