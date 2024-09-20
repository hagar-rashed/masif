<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoomOffer;
use App\Models\RoomOfferBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class RoomOfferController extends Controller
{
    // Store a new room offer
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'offer_name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price_before_offer' => 'required|integer',
            'discount' => 'required|integer|min:0|max:100',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // Calculate price_after_offer based on discount percentage
        $priceBeforeOffer = $request->price_before_offer;
        $discountPercentage = $request->discount;
        $priceAfterOffer = $priceBeforeOffer - ($priceBeforeOffer * $discountPercentage / 100);
    
        // Create a new room offer
        $offer = RoomOffer::create([
            'room_id' => $request->room_id,
            'offer_name' => $request->offer_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'price_before_offer' => $priceBeforeOffer,
            'price_after_offer' => $priceAfterOffer,
            'discount' => $discountPercentage,
        ]);
    
        return response()->json([
            'message' => 'Room offer created successfully',
            'offer' => $offer
        ], 201);
    }
    
    // List all room offers
    public function index()
    {
        $offers = RoomOffer::all();
        return response()->json($offers, 200);
    }
    
    // Show details of a specific room offer
    public function show($id)
    {
        $offer = RoomOffer::findOrFail($id);
        return response()->json($offer, 200);
    }


    


    public function bookRoomOffer(Request $request)
    {
        // Validate request
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'offer_id' => 'required|exists:room_offers,id',
        ]);
    
        // Fetch the offer to check its end_date
        $offer = RoomOffer::findOrFail($request->offer_id);
    
        // Check if the offer is still available (i.e., today's date is on or before the end_date)
        if (now()->gt($offer->end_date)) {
            return response()->json([
                'message' => 'This offer has expired and can no longer be booked.'
            ], 400);
        }
    
        // Create a booking record
        $booking = RoomOfferBooking::create([
            'room_id' => $request->room_id,
            'user_id' => auth()->id(), // Assuming the user is authenticated
            'offer_id' => $request->offer_id,
        ]);
    
        // Generate QR code for the booking
        $qrData = [
            'booking_id' => $booking->id,
            'room_id' => $booking->room_id,
            'user_id' => $booking->user_id,
            'offer_id' => $booking->offer_id,
        ];
    
        // Generate and store the QR code
        $qrCodeImage = QrCode::format('png')->size(200)->generate(json_encode($qrData));
        $qrCodePath = 'qrcodes/booking_' . $booking->id . '.png';
        Storage::disk('public')->put($qrCodePath, $qrCodeImage);
    
        // Update the booking with the QR code path
        $booking->qr_code_path = $qrCodePath;
        $booking->save();
    
        // Load related room, room images, offer details, and user
        $booking->load(['room.images', 'offer', 'user']);
    
        // Return the booking, room with images, full offer details, and QR code path
        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => [
                'id' => $booking->id,
                'user_id' => $booking->user_id, // Include the user ID
                'room' => [
                    'room_type' => $booking->room->room_type,
                    'images' => $booking->room->images->map(function ($image) {
                        return Storage::disk('public')->url($image->image_path);
                    }), // Map images to URLs
                ],
                'offer' => [
                    'offer_name' => $booking->offer->offer_name,
                    'start_date' => $booking->offer->start_date,
                    'end_date' => $booking->offer->end_date,
                    'price_before_offer' => $booking->offer->price_before_offer,
                    'price_after_offer' => $booking->offer->price_after_offer,
                    'discount' => $booking->offer->discount,
                ],
                'qr_code_url' => Storage::disk('public')->url($qrCodePath),
            ],
        ], 201);
    }
}    