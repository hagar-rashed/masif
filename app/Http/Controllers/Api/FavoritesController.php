<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\OfferTrip;

class FavoritesController extends Controller
{
    // Add an item to the user's favorites
    public function store(Request $request)
    {
        $validated = $request->validate([
            'favoritable_type' => 'required|string',
            'favoritable_id'   => 'required|integer',
        ]);
    
        // Log the incoming data for debugging
        \Log::info('Favoriting item:', $validated);
    
        // Get the authenticated user
        $user = auth()->user();
    
        // Check if the item is already in favorites
        $favoriteExists = Favorite::where('user_id', $user->id)
            ->where('favoritable_type', $validated['favoritable_type'])
            ->where('favoritable_id', $validated['favoritable_id'])
            ->exists();
    
        if ($favoriteExists) {
            return response()->json(['message' => 'Item already in favorites'], 409);
        }
    
        // Add the item to favorites
        $favorite = Favorite::create([
            'user_id'          => $user->id,
            'favoritable_type' => $validated['favoritable_type'],
            'favoritable_id'   => $validated['favoritable_id'],
        ]);
    
        // Log the newly created favorite for debugging
        \Log::info('Favorite created:', $favorite->toArray());
    
        return response()->json(['message' => 'Added to favorites successfully'], 201);
    }
    

    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Retrieve the user's favorites and load the related offer trip details
        $favorites = Favorite::where('user_id', $user->id)
            ->with('favoritable') // Ensure favoritable model is loaded
            ->get();

        return response()->json($favorites);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'favoritable_type' => 'required|string',
            'favoritable_id' => 'required|integer',
        ]);

        $user = $request->user();

        // Remove the item from favorites
        Favorite::where('user_id', $user->id)
            ->where('favoritable_type', $request->favoritable_type)
            ->where('favoritable_id', $request->favoritable_id)
            ->delete();

        return response()->json(['message' => 'Removed from favorites successfully']);
    }
}

