<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Models\RoomImage; 
use App\Models\RoomAvailability; 
use App\Models\RoomOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('availability', 'images', 'offers')->get();
        return response()->json([
            'rooms' => $rooms
        ], 200);
    }

    public function show($id)
    {
        $room = Room::with(['availability', 'images', 'offers'])->findOrFail($id);
        return response()->json($room, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|exists:hotels,id',
            'room_type' => 'required|string',
            'number_of_beds' => 'required|integer',
            'service' => 'required|string',
            'space' => 'required|string',
            'night_price' => 'required|integer',
            'description' => 'nullable|string',
            'facilities' => 'nullable|array',
            'payment_method' => 'required|string',
            'discount' => 'nullable|integer',
            'availability' => 'required|array',
            'availability.*.start_date' => 'required|date',
            'availability.*.end_date' => 'required|date|after_or_equal:availability.*.start_date',
            'offers' => 'nullable|array',
            'offers.*.description' => 'required|string',
            'offers.*.start_date' => 'required|date',
            'offers.*.end_date' => 'required|date|after_or_equal:offers.*.start_date',
            'offers.*.discount' => 'required|integer',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Store room details
        $room = Room::create($request->only([
            'hotel_id', 'room_type', 'space', 'number_of_beds', 'service', 'night_price', 
            'description', 'facilities', 'payment_method', 'discount'
        ]));

        // Store room availability
        foreach ($request->availability as $availability) {
            RoomAvailability::create([
                'room_id' => $room->id,
                'start_date' => $availability['start_date'],
                'end_date' => $availability['end_date'],
            ]);
        }

        // Handle offers if provided
        if ($request->has('offers')) {
            foreach ($request->offers as $offer) {
                RoomOffer::create([
                    'room_id' => $room->id,
                    'description' => $offer['description'],
                    'start_date' => $offer['start_date'],
                    'end_date' => $offer['end_date'],
                    'discount' => $offer['discount'],
                ]);
            }
        }

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('rooms', 'public'); // Store the image

                // Create a RoomImage record for each image
                RoomImage::create([
                    'room_id' => $room->id,
                    'image_path' => $imagePath
                ]);
            }
        }

        // Return room with availability, images, and offers in the response
        $room->load('availability', 'images', 'offers');  // Load images and offers

        return response()->json([
            'message' => 'Room created successfully',
            'room' => $room
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'room_type' => 'sometimes|required|string',
            'number_of_beds' => 'sometimes|required|integer',
            'service' => 'sometimes|required|string',
            'space' => 'sometimes|required|string',
            'night_price' => 'sometimes|required|integer',
            'description' => 'nullable|string',
            'facilities' => 'nullable|array',
            'payment_method' => 'sometimes|required|string',
            'discount' => 'nullable|integer',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'availability' => 'nullable|array',
            'availability.*.start_date' => 'required_with:availability|date',
            'availability.*.end_date' => 'required_with:availability|date|after_or_equal:availability.*.start_date',
            'offers' => 'nullable|array',
            'offers.*.offer_name' => 'required|string',
            'offers.*.start_date' => 'required|date',
            'offers.*.end_date' => 'required|date|after_or_equal:offers.*.start_date',
            'offers.*.discount' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $room = Room::findOrFail($id);

        // Update the room fields
        $room->update($request->only([
            'room_type', 'number_of_beds', 'service', 'space', 'night_price',
            'description', 'facilities', 'payment_method', 'discount'
        ]));

        // Handle image uploads if provided
        if ($request->hasFile('images')) {
            RoomImage::where('room_id', $room->id)->delete(); // This deletes old images

            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('rooms', 'public'); // Store each image

                RoomImage::create([
                    'room_id' => $room->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        // Update room availability if provided
        if ($request->has('availability')) {
            RoomAvailability::where('room_id', $room->id)->delete(); // Delete old availability records

            foreach ($request->availability as $availability) {
                RoomAvailability::create([
                    'room_id' => $room->id,
                    'start_date' => $availability['start_date'],
                    'end_date' => $availability['end_date'],
                ]);
            }
        }

        // Update offers if provided
        if ($request->has('offers')) {
            RoomOffer::where('room_id', $room->id)->delete(); // Delete old offers

            foreach ($request->offers as $offer) {
                RoomOffer::create([
                    'room_id' => $room->id,
                    'offer_name' => $offer['offer_name'],
                    'start_date' => $offer['start_date'],
                    'end_date' => $offer['end_date'],
                    'discount' => $offer['discount'],
                ]);
            }
        }

        $room->load('availability', 'images', 'offers');  // Load images and offers

        return response()->json([
            'message' => 'Room updated successfully',
            'room' => $room
        ], 200);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        // Delete related availability and offers
        RoomAvailability::where('room_id', $id)->delete();
        RoomOffer::where('room_id', $id)->delete();
        RoomImage::where('room_id', $id)->delete();

        // Delete the room
        $room->delete();

        return response()->json([
            'message' => 'Room deleted successfully'
        ], 200);
    }
}
