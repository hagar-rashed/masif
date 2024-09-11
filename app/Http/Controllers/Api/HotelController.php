<?php

namespace App\Http\Controllers\Api;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class HotelController extends Controller
{
    public function index() {
        try {
            $hotels = Hotel::with('rooms')->get();
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
        $hotel = Hotel::with('rooms')->find($id);

        if (!$hotel) {
            return response()->json(['error' => 'Hotel not found'], 404);
        }

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
                'star_rating' => 'integer|nullable',
                'services' => 'array|nullable',
            ], $this->validationMessages());

            $validated['user_id'] = auth()->id();

            if ($request->hasFile('image_path')) {
                $validated['image_path'] = $request->file('image_path')->store('hotels', 'public');
            }

            $hotel = Hotel::create($validated);

            // Handle multiple image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('hotel_images', 'public');
                    $hotel->images()->create(['image_path' => $imagePath]);
                }
            }

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

    public function update(Request $request, $id) {
        try {
            $hotel = Hotel::find($id);

            if (!$hotel) {
                return response()->json(['error' => 'Hotel not found'], 404);
            }

            $validated = $request->validate([
                'name' => 'string|nullable',
                'image_path' => 'file|nullable',
                'qr_code' => 'string|nullable',
                'phone' => 'string|nullable',
                'location' => 'string|nullable',
                'star_rating' => 'integer|nullable',
                'services' => 'array|nullable',
            ], $this->validationMessages());

            // Handle image upload
            if ($request->hasFile('image_path')) {
                $validated['image_path'] = $request->file('image_path')->store('hotels', 'public');
            }

            $hotel->update($validated);

            return response()->json([
                'message' => 'Hotel updated successfully',
                'data' => $hotel,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating the hotel',
                'message' => $e->getMessage(),
            ], 500);
        }
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
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json(['error' => 'Hotel not found'], 404);
        }

        // Get rooms associated with the hotel
        $rooms = $hotel->rooms; // Assuming the Hotel model has a relationship with Room

        return response()->json($rooms);
    }
}
