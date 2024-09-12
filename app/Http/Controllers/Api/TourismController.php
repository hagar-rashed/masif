<?php

namespace App\Http\Controllers\Api;

use App\Models\Tourism;
use App\Models\OfferTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class TourismController extends Controller
{
    // Display all tourism entries
    public function index()
    {
        $tourisms = Tourism::all();
        
        // Format image paths for all tourism entries
        $tourisms->transform(function ($tourism) {
            $tourism->image_url = str_replace('public/', '', $tourism->image_url);
            return $tourism;
        });

        return response()->json($tourisms, 200);
    }

    // Store a new tourism entry
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'image_url' => 'required|image',
            'phone' => 'required|string',
            'location' => 'required|string',
            'description' => 'required',
            'facilities' => 'required|array',
            'facilities.*' => 'string',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $validatedData = $request->all(); // Preserve validated data

        // Handle image upload if present
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('tourisms', 'public');
            $validatedData['image_url'] = $imagePath;
        }

        $tourism = Tourism::create($validatedData);

        // Format the image path to exclude the full URL
        $tourism->image_url = isset($validatedData['image_url']) ? str_replace('public/', '', $validatedData['image_url']) : null;

        return response()->json($tourism, 201);
    }

    // Show a specific tourism entry
    public function show($id)
    {
        $tourism = Tourism::find($id);

        if (!$tourism) {
            return response()->json(['message' => 'Tourism not found'], 404);
        }

        // Format the image path to exclude the full URL
        $tourism->image_url = str_replace('public/', '', $tourism->image_url);

        return response()->json($tourism, 200);
    }

    // Update a tourism entry
    public function update(Request $request, $id)
    {
        $tourism = Tourism::find($id);

        if (!$tourism) {
            return response()->json(['message' => 'Tourism not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string',
            'image_url' => 'sometimes|image',
            'phone' => 'sometimes|string',
            'location' => 'sometimes|string',
            'description' => 'sometimes',
            'facilities' => 'sometimes|array',
            'facilities.*' => 'string',
            'rating' => 'sometimes|numeric|min:0|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->hasFile('image_url')) {
            // Delete the old image if it exists
            if ($tourism->image_url) {
                Storage::disk('public')->delete($tourism->image_url);
            }

            // Store the new image
            $imagePath = $request->file('image_url')->store('tourisms', 'public');
            $request->merge(['image_url' => $imagePath]);
        }

        // Update the tourism entry
        $tourism->update($request->all());

        // Format the image path to exclude the full URL
        $tourism->image_url = isset($request->image_url) ? str_replace('public/', '', $request->image_url) : $tourism->image_url;

        return response()->json($tourism, 200);
    }

    // Delete a tourism entry
    public function destroy($id)
    {
        $tourism = Tourism::find($id);

        if (!$tourism) {
            return response()->json(['message' => 'Tourism not found'], 404);
        }

        Storage::disk('public')->delete($tourism->image_url);
        $tourism->delete();

        return response()->json(['message' => 'Tourism deleted'], 200);
    }

    // Retrieve trips by tourism ID
    public function getTripsByTourism($tourismId)
    {
        try {
            $trips = OfferTrip::where('tourism_id', $tourismId)->get();

            if ($trips->isEmpty()) {
                return response()->json([
                    'message' => 'No trips found for the specified tourism.',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Trips retrieved successfully.',
                'data' => $trips
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred while retrieving the trips.',
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }
}
