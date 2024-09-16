<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Models\RoomAvailability; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    
public function index()
{
    $rooms = Room::with('availability')->get();
    return response()->json([
        'rooms' => $rooms
    ], 200);
}

    // Store a new room and its availability
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
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048' // Ensure image is provided
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public'); // Store the image
        }
    
        // Store room details
        $room = Room::create([
            'hotel_id' => $request->hotel_id,
            'room_type' => $request->room_type,
            'space' => $request->space, // Ensure space is stored
            'number_of_beds' => $request->number_of_beds,
            'service' => $request->service,
            'night_price' => $request->night_price,
            'description' => $request->description,
            'facilities' => $request->facilities,
            'payment_method' => $request->payment_method,
            'discount' => $request->discount,
            'image_path' => $imagePath // Store the image path
        ]);
    
        // Store room availability
        foreach ($request->availability as $availability) {
            RoomAvailability::create([
                'room_id' => $room->id,
                'start_date' => $availability['start_date'],
                'end_date' => $availability['end_date'],
            ]);
        }
    
        // Return room with availability in the response
        $room->load('availability');
    
        return response()->json([
            'message' => 'Room created successfully',
            'room' => $room
        ], 201);
    }
    
    

    // Show a specific room with its availability
    public function show($id)
    {
        $room = Room::with('availability')->findOrFail($id);
        return response()->json($room, 200);
    }

    // Update a room and its availability
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',// Make the image nullable
            'availability' => 'nullable|array',
            'availability.*.start_date' => 'required_with:availability|date',
            'availability.*.end_date' => 'required_with:availability|date|after_or_equal:availability.*.start_date',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        $room = Room::findOrFail($id);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public');
            $room->image_path = $imagePath;
        }
    
        $room->update($request->only([
            'room_type', 'number_of_beds', 'service', 'space', 'night_price',
            'description', 'facilities', 'payment_method', 'discount'
        ]));
    
        // Update room availability if provided
        if ($request->has('availability')) {
            RoomAvailability::where('room_id', $room->id)->delete();
    
            foreach ($request->availability as $availability) {
                RoomAvailability::create([
                    'room_id' => $room->id,
                    'start_date' => $availability['start_date'],
                    'end_date' => $availability['end_date'],
                ]);
            }
        }
    
        $room->load('availability');  // Load the updated availability
    
        return response()->json([
            'message' => 'Room updated successfully',
            'room' => $room
        ], 200);
    }
    

    // Delete a room and its availability
    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        $room->delete();

        return response()->json(['message' => 'Room deleted successfully'], 200);
    }
}    