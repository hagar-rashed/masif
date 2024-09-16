<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\OwnerUnit;
use App\Models\Room;
use App\Models\OfferTrip;

class FavoritesController extends Controller
{
    // Retrieve favorites and separate by type
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Initialize arrays for each type
        $separatedFavorites = [
            'rooms' => [],
            'trips' => [],
            'units' => []
        ];

        // Retrieve the user's favorites
        $favorites = Favorite::where('user_id', $user->id)->get();

        foreach ($favorites as $favorite) {
            $favoritable = $this->getFavoritable($favorite->favoritable_type, $favorite->favoritable_id);
            
            if ($favoritable) {
                switch ($favorite->favoritable_type) {
                    case 'room':
                        $separatedFavorites['rooms'][] = $favoritable;
                        break;
                    case 'trip':
                        $separatedFavorites['trips'][] = $favoritable;
                        break;
                    case 'unit':
                        $separatedFavorites['units'][] = $favoritable;
                        break;
                }
            }
        }

        return response()->json($separatedFavorites);
    }

    // Helper method to get favoritable item details
    private function getFavoritable($type, $id)
    {
        switch ($type) {
            case 'room':
                return Room::find($id);
            case 'trip':
                return OfferTrip::find($id);
            case 'unit':
                return OwnerUnit::find($id);
            default:
                return null;
        }
    }

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

    // Remove an item from favorites
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
