<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\RestaurantCategory;
use Illuminate\Support\Facades\Storage;

class RestaurantCategoryController extends Controller
{

    public function index($id)
{
    try {
        $restaurantCategories = RestaurantCategory::where('restaurant_id', $id)->get();
        foreach ($restaurantCategories as $category) {
            $category->image_url = $category->image_url ? $category->image_url : null;  // Return only the path, not the full URL
        }

        return response()->json($restaurantCategories);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while retrieving categories. Please try again later.'], 500);
    }
}


public function show($id)
{
    try {
        $restaurantCategory = RestaurantCategory::findOrFail($id);
        $restaurantCategory->image_url = $restaurantCategory->image_url ? $restaurantCategory->image_url : null;  // Return only the path, not the full URL

        return response()->json($restaurantCategory);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Category not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while retrieving the category. Please try again later.'], 500);
    }
}

public function store(Request $request, $restaurant_id)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image upload
    ]);

    // Find the restaurant by ID
    $restaurant = Restaurant::findOrFail($restaurant_id);

    // Prepare the data to be saved
    $categoryData = [
        'name' => $validatedData['name'],
        'restaurant_id' => $restaurant->id,
    ];

    // Check if an image was uploaded
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('restaurant', 'public');
        $categoryData['image_url'] = $imagePath;
    }

    // Create the category
    $category = RestaurantCategory::create($categoryData);
    
    return response()->json($category, 201);
}


public function update(Request $request, $restaurant_id, $category_id)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Find the restaurant and category
    $restaurant = Restaurant::findOrFail($restaurant_id);
    $category = RestaurantCategory::where('restaurant_id', $restaurant->id)->findOrFail($category_id);

    // Prepare data for update
    $categoryData = [
        'name' => $validatedData['name'],
    ];

    // Check if an image is uploaded and handle the previous image
    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($category->image_url && Storage::disk('public')->exists($category->image_url)) {
            Storage::disk('public')->delete($category->image_url);
        }
        // Store the new image
        $imagePath = $request->file('image')->store('restaurant', 'public');
        $categoryData['image_url'] = $imagePath;
    }

    // Update the category
    $category->update($categoryData);
    
    return response()->json($category, 200);
}





public function destroy($id)
{
    try {
        $category = RestaurantCategory::findOrFail($id);

        // Delete the image if it exists
        if ($category->image_url) {
            $imagePath = $category->image_url; // Directly use the stored image path

            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        // Delete the category
        $category->delete();

        return response()->json(['message' => 'Category and associated data deleted successfully.'], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Category not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while deleting the category. Please try again later.'], 500);
    }
}

}