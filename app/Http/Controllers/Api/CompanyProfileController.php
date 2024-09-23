<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyProfileController extends Controller
{
    public function enterpriseProfile($id)
    {
        // Retrieve the user (company) by ID
        $company = User::where('id', $id)
            ->where('user_type', 'company')
            ->with([
                'restaurants.categories.items',
                'cafes.categories.items',
                'cinemas.movies.screens.seats', 
                'hotels.rooms',                 
                'tourisms',                     
                'others'                        
            ])
            ->first();
    
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }
    
        // Prepare the activity data based on the company activity type
        $activityData = [];
    
        switch ($company->company_activity) {
            case 'restaurant':
                // Get restaurant data with categories and items
                $restaurants = $company->restaurants()->get()->map(function($restaurant) {
                    $restaurant->image_url = $restaurant->image_url ? asset('storage/' . $restaurant->image_url) : null;
    
                    if ($restaurant->categories) {
                        $restaurant->categories->each(function ($category) {
                            if ($category->items) {
                                $category->items->each(function ($item) {
                                    $item->image_url = $item->image ? asset('storage/' . $item->image) : null;
                                });
                            }
                        });
                    }
                    return $restaurant;
                });
                $activityData = $restaurants;
                break;
    
            case 'cafe':
                // Get cafe data with categories and items
                $cafes = $company->cafes()->get()->map(function($cafe) {
                    $cafe->image_url = $cafe->image_url ? asset('storage/' . $cafe->image_url) : null;
    
                    if ($cafe->categories) {
                        $cafe->categories->each(function ($category) {
                            if ($category->items) {
                                $category->items->each(function ($item) {
                                    $item->image_url = $item->image ? asset('storage/' . $item->image) : null;
                                });
                            }
                        });
                    }
    
                    return $cafe;
                });
                $activityData = $cafes;
                break;
    
            case 'cinema':
                // Get cinema data with movies, screens, and seats
                $cinemas = $company->cinemas()->get()->map(function($cinema) {
                    $cinema->image_url = $cinema->image_url ? asset('storage/' . $cinema->image_url) : null;
    
                    $cinema->movies->each(function($movie) {
                        $movie->screens->each(function($screen) {
                            $screen->seats->each(function($seat) {
                                // Customize seat details if needed
                            });
                        });
                    });
    
                    return $cinema;
                });
                $activityData = $cinemas;
                break;
    
            case 'hotel':
                // Get hotel data with rooms
                $hotels = $company->hotels()->get()->map(function($hotel) {
                    $hotel->image_url = $hotel->image_url ? asset('storage/' . $hotel->image_url) : null;
    
                    if ($hotel->rooms) {
                        $hotel->rooms->each(function ($room) {
                            $room->image_url = $room->image ? asset('storage/' . $room->image) : null;
                        });
                    }
    
                    return $hotel;
                });
                $activityData = $hotels;
                break;
    
            case 'tourism':
                // Get tourism data
                $tourisms = $company->tourisms()->get()->map(function($tourism) {
                    $tourism->image_url = $tourism->image ? asset('storage/' . $tourism->image) : null;
                    return $tourism;
                });
                $activityData = $tourisms;
                break;
    
            case 'other':
                // Get other data
                $others = $company->others()->get()->map(function($other) {
                    $other->image_url = $other->image ? asset('storage/' . $other->image) : null;
                    return $other;
                });
                $activityData = $others;
                break;
    
            default:
                $activityData = []; // No activity found
                break;
        }
    
        // Return the company profile with company activity and associated data
        return response()->json([
            'activity_data' => $activityData, // Include the activity data (restaurants, cafes, cinemas, etc.)
        ]);
    }
    


    public function dashboardLink()
    {
         $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized. Please log in.'], 401);
        }

        if ($user->user_type !== 'owner') {
            return response()->json(['error' => 'Forbidden,user type must be owner'], 403);
        }
        $url ="";
        return response()->json($url,200); 
    }
}