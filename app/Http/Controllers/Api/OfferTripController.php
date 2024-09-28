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
        $trips = OfferTrip::with('tourism')->get();

        return response()->json([
            'message' => 'Trips retrieved successfully.',
            'data' => $trips
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'error' => 'An unexpected error occurred while retrieving trips.',
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
}




public function show($id)
{
    try {
        $trip = OfferTrip::with('tourism')->findOrFail($id);

        return response()->json([
            'message' => 'Trip retrieved successfully.',
            'data' => $trip
        ], 200);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'error' => 'Trip not found.',
            'details' => $e->getMessage()
        ], 404);
    } catch (Exception $e) {
        return response()->json([
            'error' => 'An unexpected error occurred while retrieving the trip.',
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
}


    public function store(Request $request, $tourismId)
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
                'cost_before_discount' => 'nullable|numeric', // Ensure it's validated if optional
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
    
            // Associate the trip with the tourism entity
            $validated['tourism_id'] = $tourismId;
    
            // Create a new trip
            $trip = OfferTrip::create($validated);
    
            // Send notification to all users (except the current user)
            $users = User::where('id', '!=', Auth::id())->get();
            foreach ($users as $user) {
                $user->notify(new OfferTripNotification($trip));
            }
    
            return response()->json([
                'message' => 'Trip created successfully.',
                'data' => $trip->only(['id', 'user_id', 'tourism_id', 'name', 'image_path', 'description', 'rating', 'reviews_count', 'start_time', 'end_time', 'destination', 'trip_schedule', 'transportation', 'hotel_name', 'hotel_address', 'hotel_phone','cost_before_discount', 'trip_cost', 'tax','total_cost', 'created_at', 'updated_at'])
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed.',
                'details' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred while creating the trip.',
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    



    public function update(Request $request, $id)
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
                'cost_before_discount' => 'nullable|numeric',

                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
    
            // Calculate total_cost
            $validated['total_cost'] = $validated['trip_cost'] + $validated['tax'];
    
            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('trips', 'public');
                $validated['image_path'] = $imagePath;
            }
    
            $trip = OfferTrip::findOrFail($id);
            $trip->update($validated);
    
            return response()->json([
                'message' => 'Trip updated successfully.',
                'data' => $trip
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed.',
                'details' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Trip not found.',
                'details' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred while updating the trip.',
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    
    public function destroy($id)
    {
        try {
            $trip = OfferTrip::findOrFail($id);
            $trip->delete();
    
            return response()->json([
                'message' => 'Trip deleted successfully.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Trip not found.',
                'details' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred while deleting the trip.',
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    

    public function getTripsByUser($userId)
{
    try {
        $trips = OfferTrip::where('user_id', $userId)->with('tourism')->get();

        return response()->json([
            'message' => 'Trips retrieved successfully.',
            'data' => $trips
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'error' => 'An unexpected error occurred while retrieving trips by user.',
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
}

public function getAuthenticatedUserTrips()
{
    try {
        $userId = Auth::id();
        $trips = OfferTrip::where('user_id', $userId)->with('tourism')->get();

        return response()->json([
            'message' => 'Trips retrieved successfully.',
            'data' => $trips
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'error' => 'An unexpected error occurred while retrieving authenticated user trips.',
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
}

public function getTripsWithOffers()
{

try {
    // Retrieve only trips where 'cost_before_discount' is not null
    $trips = OfferTrip::with('tourism')
        ->whereNotNull('cost_before_discount')
        ->get();

    return response()->json([
        'message' => 'Trips with offers retrieved successfully.',
        'data' => $trips
    ], 200);
} catch (Exception $e) {
    return response()->json([
        'error' => 'An unexpected error occurred while retrieving trips.',
        'exception' => get_class($e),
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ], 500);
}
}
}



   
    
    