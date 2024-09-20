<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomBooking;
use App\Models\TripBooking;
use App\Models\RestaurantBooking;
use App\Models\CafeBooking;
use App\Models\SeatBooking;

use Illuminate\Support\Facades\Auth;


class MyQRCodeController extends Controller
{
    public function myQRCodes()
{
    // Retrieve QR codes for trip bookings with trip name and image path
    $tripBookings = TripBooking::where('user_id', Auth::id())
        ->whereNotNull('qr_code_path')
        ->with(['tripOffer' => function ($query) {
            $query->select('id', 'name', 'image_path');
        }])
        ->get(['id', 'trip_offer_id', 'qr_code_path']);

    // Format trip bookings to include trip name and image path
    $formattedTripBookings = $tripBookings->map(function ($booking) {
        return [
            'id' => $booking->id,
            'trip_offer_id' => $booking->trip_offer_id,
            'qr_code_path' => $booking->qr_code_path,
            'trip_name' => $booking->tripOffer->name,
            'trip_image_path' => $booking->tripOffer->image_path,
        ];
    });

    // Retrieve QR codes for room bookings with hotel, room type, and room images
    $roomBookings = RoomBooking::where('user_id', Auth::id())
        ->whereNotNull('qr_code_path')
        ->with(['room' => function ($query) {
            $query->select('id', 'hotel_id', 'room_type')
                  ->with('images:id,room_id,image_path');
        }])
        ->get(['id', 'room_id', 'qr_code_path']);

    // Format room bookings to include hotel_id, room_type, and images
    $formattedRoomBookings = $roomBookings->map(function ($booking) {
        return [
            'id' => $booking->id,
            'room_id' => $booking->room_id,
            'qr_code_path' => $booking->qr_code_path,
            'hotel_id' => $booking->room->hotel_id,
            'room_type' => $booking->room->room_type,
            'room_images' => $booking->room->images->pluck('image_path'),
        ];
    });

    // Retrieve QR codes for restaurant bookings with restaurant name and image_url
    $restaurantBookings = RestaurantBooking::where('user_id', Auth::id())
        ->whereNotNull('qr_code_path')
        ->with(['restaurant' => function ($query) {
            $query->select('id', 'name', 'image_url');
        }])
        ->get(['id', 'restaurant_id', 'qr_code_path']);

    // Format restaurant bookings to include name and image_url
    $formattedRestaurantBookings = $restaurantBookings->map(function ($booking) {
        return [
            'id' => $booking->id,
            'restaurant_id' => $booking->restaurant_id,
            'qr_code_path' => $booking->qr_code_path,
            'restaurant_name' => $booking->restaurant->name,
            'restaurant_image_url' => $booking->restaurant->image_url,
        ];
    });

    // Retrieve QR codes for cafe bookings with cafe name and image_url
    $cafeBookings = CafeBooking::where('user_id', Auth::id())
        ->whereNotNull('qr_code_path')
        ->with(['cafe' => function ($query) {
            $query->select('id', 'name', 'image_url');
        }])
        ->get(['id', 'cafe_id', 'qr_code_path']);

    // Format cafe bookings to include name and image_url
    $formattedCafeBookings = $cafeBookings->map(function ($booking) {
        return [
            'id' => $booking->id,
            'cafe_id' => $booking->cafe_id,
            'qr_code_path' => $booking->qr_code_path,
            'cafe_name' => $booking->cafe->name,
            'cafe_image_url' => $booking->cafe->image_url,
        ];
    });




     // Retrieve QR codes for seat bookings with seat details, movie name, and cinema name
     $seatBookings = SeatBooking::where('user_id', Auth::id())
     ->whereNotNull('qr_code')
     ->with(['seat' => function ($query) {
         $query->select('id', 'seat_number', 'screen_id')
               ->with(['screen' => function ($query) {
                   $query->select('id', 'movie_id')
                         ->with(['movie' => function ($query) {
                             $query->select('id', 'name', 'image_url', 'cinema_id') // Include image_url here
                                   ->with('cinema:id,name');
                         }]);
               }]);
     }])
     ->get(['id', 'seat_id', 'qr_code']);
 
 // Format seat bookings to include seat number, movie name, and cinema name
 $formattedSeatBookings = $seatBookings->map(function ($booking) {
    return [
        'id' => $booking->id,
        'seat_id' => $booking->seat_id,
        'qr_code' => $booking->qr_code,
        'seat_number' => $booking->seat->seat_number,
        'movie_name' => $booking->seat->screen->movie->name ?? 'N/A',
        'cinema_name' => $booking->seat->screen->movie->cinema->name ?? 'N/A',
        'movie_image_url' => $booking->seat->screen->movie->image_url ?? 'N/A', // Include movie image URL here
    ];
});

    // Group all service bookings into the response
    $serviceBookings = [
        'restaurant_bookings' => $formattedRestaurantBookings,
        'cafe_bookings' => $formattedCafeBookings,
        'cinema_bookings' => $formattedSeatBookings,
    ];

    // Prepare the response
    return response()->json([
        'message' => 'QR codes retrieved successfully',
        'trip_bookings' => $formattedTripBookings,
        'room_bookings' => $formattedRoomBookings,
        'service_bookings' => $serviceBookings,
    ], 200);
}



public function destroy($id, Request $request)
{
    // Retrieve the type from the query parameter
    $type = $request->query('type');

    // Determine the type of booking to delete
    switch ($type) {
        case 'trip':
            $booking = TripBooking::find($id);
            break;

        case 'room':
            $booking = RoomBooking::find($id);
            break;

        case 'restaurant':
            $booking = RestaurantBooking::find($id);
            break;

        case 'cafe':
            $booking = CafeBooking::find($id);
            break;

        case 'cinema':
            $booking = SeatBooking::find($id);
            break;

        default:
            return response()->json(['message' => 'Invalid booking type'], 400);
    }

    // If booking not found, return error
    if (!$booking) {
        return response()->json(['message' => 'Booking not found'], 404);
    }

    // Delete the associated QR code file if it exists
    if ($booking->qr_code_path && \Storage::exists($booking->qr_code_path)) {
        \Storage::delete($booking->qr_code_path);
    }

    // Delete the booking record from the database
    $booking->delete();

    return response()->json(['message' => 'Booking deleted successfully'], 200);
}


   
}
