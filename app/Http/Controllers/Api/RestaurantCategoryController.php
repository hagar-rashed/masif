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
            $category->image_url = $category->image_url ? asset('storage/' . $category->image_url) : null;
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
        $restaurantCategory->image_url = $restaurantCategory->image_url ? asset('storage/' . $restaurantCategory->image_url) : null;
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
        'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate as an image with specific mime types and max size
    ]);

    // Find the cafe by ID
    $restaurant = Restaurant::findOrFail($restaurant_id);

    // Prepare the data to be saved
    $categoryData = [
        'name' => $validatedData['name'],
        'restaurant_id' => $restaurant->id, // Ensure cafe_id is set
    ];

    // Check if an image was uploaded
    if ($request->hasFile('image')) {
        // Store the new image in the 'public/cafe' directory
        $imagePath = $request->file('image')->store('restaurant', 'public');
        $categoryData['image_url'] = $imagePath;
    }

    // Create a new category with the validated data
    $category = RestaurantCategory::create($categoryData);

    // Optionally, return the image URL
    if (isset($categoryData['image_url'])) {
        $category->image_url = asset('storage/' . $categoryData['image_url']);
    }

    // Return the created category as a JSON response
    return response()->json($category, 201);
}

public function update(Request $request, $restaurant_id, $category_id)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate as an image with specific mime types and max size
    ]);

    // Find the restaurant by ID
    $restaurant = Restaurant::findOrFail($restaurant_id);

    // Find the category by ID
    $category = RestaurantCategory::where('restaurant_id', $restaurant->id)->findOrFail($category_id);

    // Prepare the data to be updated
    $categoryData = [
        'name' => $validatedData['name'],
    ];

    // Check if an image was uploaded
    if ($request->hasFile('image_url')) {
        // Store the new image in the 'public/restaurant' directory
        $imagePath = $request->file('image_url')->store('restaurant', 'public');
        $categoryData['image_url'] = $imagePath;
    }

    // Update the category with the validated data
    $category->update($categoryData);

    // Ensure the complete image URL is included in the response
    $category->image_url = isset($categoryData['image_url']) 
        ? asset('storage/' . $categoryData['image_url']) 
        : asset('storage/' . $category->image_url);

    // Return the updated category as a JSON response
    return response()->json($category, 200);
}





public function destroy($id)
{
    try {
        $category = RestaurantCategory::findOrFail($id);

        if ($category->image_url) {
            $imagePath = str_replace(asset('storage/'), '', $category->image_url);

            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $category->delete();

        return response()->json(['message' => 'Category and associated data deleted successfully.'], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Category not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while deleting the category. Please try again later.'], 500);
    }
}
}