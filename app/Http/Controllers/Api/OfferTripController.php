<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfferTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OfferTripNotification;


class OfferTripController extends Controller
{
    // List all trips
    public function index()
    {
        try {
            $trips = OfferTrip::all();
            return response()->json([
                'message' => 'Trips retrieved successfully.',
                'data' => $trips
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve trips.'], 500);
        }
    }

    // Get a specific trip by ID
    public function show($id)
    {
        try {
            $trip = OfferTrip::findOrFail($id);
            return response()->json([
                'message' => 'Trip retrieved successfully.',
                'data' => $trip
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Trip not found.'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while retrieving the trip.'], 500);
        }
    }
   

    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'rating' => 'required|numeric',
            'reviews_count' => 'required|integer',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'destination' => 'required|string',
            'trip_schedule' => 'required|string',
            'transportation' => 'required|string',
            'hotel_name' => 'required|string',
            'hotel_address' => 'required|string',
            'hotel_phone' => 'nullable|string|max:15',
            'trip_cost' => 'required|numeric',
            'tax' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Calculate total_cost
        $validated['total_cost'] = $validated['trip_cost'] + $validated['tax'];

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('trips', 'public');
            $validated['image_path'] = $imagePath;
        }

        // Get the authenticated user ID
        $validated['user_id'] = Auth::id();

        // Create a new trip
        $trip = OfferTrip::create($validated);

        
            // Send notification to all users (except the current user)
            $users = User::where('id', '!=', Auth::id())->get();
            foreach ($users as $user) {
                $user->notify(new OfferTripNotification($trip));
            }
    

        return response()->json([
            'message' => 'Trip created successfully.',
            'data' => $trip
        ], 201);
    } catch (ValidationException $e) {
        return response()->json([
            'error' => 'Validation failed.',
            'details' => $e->errors()
        ], 422);
    } catch (Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while creating the trip.'], 500);
    }
}




public function update(Request $request, $id)
{
    try {
        $trip = OfferTrip::findOrFail($id);

        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'rating' => 'numeric',
            'reviews_count' => 'integer',
            'start_time' => 'date',
            'end_time' => 'date',
            'destination' => 'string',
            'trip_schedule' => 'string',
            'transportation' => 'string',
            'hotel_name' => 'string',
            'hotel_address' => 'string',
            'hotel_phone' => 'string|max:15',
            'trip_cost' => 'numeric',
            'tax' => 'numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Calculate total_cost if trip_cost and tax are present
        if (isset($validated['trip_cost']) && isset($validated['tax'])) {
            $validated['total_cost'] = $validated['trip_cost'] + $validated['tax'];
        }

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($trip->image_path) {
                Storage::disk('public')->delete(str_replace('storage/', '', $trip->image_path));
            }
            $imagePath = $request->file('image')->store('trips', 'public');
            $validated['image_path'] = '' . $imagePath;
        }

        $trip->update($validated);
        return response()->json([
            'message' => 'Trip updated successfully.',
            'data' => $trip
        ], 200);
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Trip not found.'], 404);
    } catch (ValidationException $e) {
        return response()->json([
            'error' => 'Validation failed.',
            'details' => $e->errors()
        ], 422);
    } catch (Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while updating the trip.'], 500);
    }
}

    // Delete a trip
    public function destroy($id)
    {
        try {
            $trip = OfferTrip::findOrFail($id);
    
            // Delete image if exists
            if ($trip->image_path) {
                Storage::disk('public')->delete(str_replace('storage/', '', $trip->image_path));
            }
    
            $trip->delete();
            return response()->json(['message' => 'Trip deleted successfully.'], 200); // Changed status code to 200
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Trip not found.'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while deleting the trip.'], 500);
        }
    }


    public function getTripsByUser($userId)
    {
        try {
            $trips = OfferTrip::where('user_id', $userId)->get();

            if ($trips->isEmpty()) {
                return response()->json([
                    'message' => 'No trips found for the specified user.',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Trips retrieved successfully.',
                'data' => $trips
            ], 200);
        } catch (Exception $e) {
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


    public function getAuthenticatedUserTrips()
    {
        try {
            // Get the authenticated user ID
            $userId = Auth::id();
    
            if (!$userId) {
                return response()->json([
                    'message' => 'User not authenticated.',
                    'data' => []
                ], 401);
            }
    
            // Retrieve all trips for the authenticated user
            $trips = OfferTrip::where('user_id', $userId)->get();
    
            if ($trips->isEmpty()) {
                return response()->json([
                    'message' => 'No trips found for the authenticated user.',
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
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
   
    
}    