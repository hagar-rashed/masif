<?php

namespace App\Http\Controllers\Api;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use SimpleSoftwareIO\QrCode\Facades\QrCode; 

class HotelController extends Controller
{
    public function index() {
        try {
            $hotels = Hotel::with(['images'])->get(); // Load associated hotel images

            // Format image paths
            $hotels->each(function ($hotel) {
                $hotel->images->each(function ($image) {
                    // Set image_path to the relative path
                    $image->image_path = '' . $image->image_path;
                });

                // Include QR code path
                $hotel->qr_code_url = '' . $hotel->qr_code;
            });

            return response()->json([
                'message' => 'Hotels retrieved successfully',
                'data' => $hotels,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to retrieve hotels',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id) {
        $hotel = Hotel::with(['images'])->find($id); // Load associated hotel images

        if (!$hotel) {
            return response()->json(['error' => 'Hotel not found'], 404);
        }

        // Format image paths
        $hotel->images->each(function ($image) {
            // Set image_path to the relative path
            $image->image_path = '' . $image->image_path;
        });

        // Include QR code path
        $hotel->qr_code_url = '' . $hotel->qr_code;

        return response()->json([
            'message' => 'Hotel retrieved successfully',
            'data' => $hotel,
        ], 200);
    }

    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'image_path' => 'file|nullable', // Main image
                'images' => 'array|nullable',    // Array of images
                'images.*' => 'file|image',      // Validate each image
                'qr_code' => 'string|nullable',
                'phone' => 'string|nullable',
                'location' => 'string|nullable',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'star_rating' => 'integer|nullable',
                'services' => 'array|nullable',
            ], $this->validationMessages());
    
            $validated['user_id'] = auth()->id();
    
            if ($request->hasFile('image_path')) {
                $validated['image_path'] = $request->file('image_path')->store('hotels', 'public');
            }
    
            // Create the hotel entry
            $hotel = Hotel::create($validated);
    
            // Handle multiple image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('hotel_images', 'public');
                    $hotel->images()->create(['image_path' => $imagePath]);
                }
            }
    
            // Generate the QR code for the hotel data
            $qrCodeData = [
                'name' => $hotel->name,
                'location' => $hotel->location,
                'phone' => $hotel->phone,
                'latitude' => $hotel->latitude,
                'longitude' => $hotel->longitude,
            ];
            
            // Convert the data to a JSON string for QR code
            $qrCodeString = json_encode($qrCodeData);
    
            // Generate and store the QR code
            $qrCodePath = 'qrcodes/' .  'hotel' . $hotel->id . '.png';
            QrCode::format('png')->size(200)->generate($qrCodeString, public_path('storage/' . $qrCodePath));
    
            // Save the QR code path in the database
            $hotel->update(['qr_code' => $qrCodePath]);
    
            return response()->json([
                'message' => 'Hotel created successfully',
                'data' => $hotel->load('images'),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while creating the hotel',
                'message' => $e->getMessage(),
            ], 500);
        }
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
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Allow multiple images
        'availability' => 'nullable|array',
        'availability.*.start_date' => 'required_with:availability|date',
        'availability.*.end_date' => 'required_with:availability|date|after_or_equal:availability.*.start_date',
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
        // Delete old images if needed, or keep them based on your requirements.
        RoomImage::where('room_id', $room->id)->delete(); // This deletes old images

        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('rooms', 'public'); // Store each image

            // Save the image path in the `room_images` table
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

    // Load the updated availability and images
    $room->load('availability', 'images');

    return response()->json([
        'message' => 'Room updated successfully',
        'room' => $room
    ], 200);
}


    public function destroy($id) {
        try {
            $hotel = Hotel::find($id);

            if (!$hotel) {
                return response()->json(['error' => 'Hotel not found'], 404);
            }

            $hotel->delete();

            return response()->json([
                'message' => 'Hotel deleted successfully',
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the hotel',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function validationMessages() {
        return [
            'name.required' => 'The hotel name is required.',
            'image_path.file' => 'The main image must be a valid file.',
            'images.*.file' => 'Each image must be a valid file.',
            'images.*.image' => 'Each file must be an image.',
            'star_rating.integer' => 'The star rating must be an integer.',
        ];
    }
    public function rooms($id) {
        // Find the hotel by ID
        $hotel = Hotel::with('rooms.images')->find($id); // Load rooms with their images
    
        if (!$hotel) {
            return response()->json(['error' => 'Hotel not found'], 404);
        }
    
        // Get rooms associated with the hotel, including images
        $rooms = $hotel->rooms; 
    
        // Format the image paths for each room
        $rooms->each(function ($room) {
            $room->images->each(function ($image) {
                $image->image_path = '' . $image->image_path; // Ensure image path is formatted correctly
            });
        });
    
        return response()->json([
            'message' => 'Rooms retrieved successfully',
            'data' => $rooms,
        ], 200);
    }
    
}
