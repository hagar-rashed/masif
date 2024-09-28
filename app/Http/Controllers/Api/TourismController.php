<?php

namespace App\Http\Controllers\Api;

use App\Models\Tourism;
use App\Models\OfferTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Validation\ValidationException;

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
        try {
            // Validate request data
            $validated = $request->validate([
                'name' => 'required|string',
                'image_url' => 'file|image|nullable',
                'phone' => 'required|string',
                'location' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'description' => 'required|string',
                'facilities' => 'required|array',
                'facilities.*' => 'string',
                'rating' => 'required|numeric|min:0|max:5',
            ]);

            // Handle image upload if present
            if ($request->hasFile('image_url')) {
                $imagePath = $request->file('image_url')->store('tourisms', 'public');
                $validated['image_url'] = str_replace('public/', '', $imagePath);
            }

            // Add the authenticated user’s ID
            $validated['user_id'] = Auth::id(); // Adding user_id from authenticated user

            // Create the tourism entry
            $tourism = Tourism::create($validated);

            // Generate the QR code for the tourism data
            $qrCodeData = [
                'name' => $tourism->name,
                'location' => $tourism->location,
                'phone' => $tourism->phone,
                'latitude' => $tourism->latitude,
                'longitude' => $tourism->longitude,
                'description' => $tourism->description,
                'facilities' => $tourism->facilities,
                'rating' => $tourism->rating,
            ];

            // Convert the data to a JSON string for the QR code
            $qrCodeString = json_encode($qrCodeData);

            // Generate and store the QR code
            $qrCodePath = 'qrcodes/tourism_' . $tourism->id . '.png';
            QrCode::format('png')->size(200)->generate($qrCodeString, public_path('storage/' . $qrCodePath));

            // Save the QR code path in the database
            $tourism->update(['qr_code' => $qrCodePath]);

            // Format image path
            $tourism->image_url = $validated['image_url'] ?? null;
            $tourism->qr_code_url = $tourism->qr_code;

            return response()->json([
                'message' => 'Tourism created successfully',
                'data' => $tourism,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while creating the tourism entry',
                'message' => $e->getMessage(),
            ], 500);
        }
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
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
            'description' => 'sometimes|string',
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
