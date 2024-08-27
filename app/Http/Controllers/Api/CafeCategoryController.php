<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cafe;
use App\Models\CafeCategory;
use Illuminate\Support\Facades\Storage;



class CafeCategoryController extends Controller
{

    public function index($id)
{
    try {
        $cafeCategories = CafeCategory::where('cafe_id', $id)->get();
        foreach ($cafeCategories as $category) {
            $category->image_url = $category->image_url ? asset('storage/' . $category->image_url) : null;
        }
        return response()->json($cafeCategories);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while retrieving categories. Please try again later.'], 500);
    }
}


    

    public function show($id)
{
    try {
        $cafeCategory = CafeCategory::findOrFail($id);
        $cafeCategory->image_url = $cafeCategory->image_url ? asset('storage/' . $cafeCategory->image_url) : null;
        return response()->json($cafeCategory);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Category not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while retrieving the category. Please try again later.'], 500);
    }
}


  
     public function store(Request $request, $cafe_id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate as an image with specific mime types and max size
        ]);
    
        // Find the cafe by ID
        $cafe = Cafe::findOrFail($cafe_id);
    
        // Prepare the data to be saved
        $categoryData = [
            'name' => $validatedData['name'],
            'cafe_id' => $cafe->id, // Ensure cafe_id is set
        ];
    
        // Check if an image was uploaded
        if ($request->hasFile('image')) {
            // Store the new image in the 'public/cafe' directory
            $imagePath = $request->file('image')->store('cafe', 'public');
            $categoryData['image_url'] = $imagePath;
        }
    
        // Create a new category with the validated data
        $category = CafeCategory::create($categoryData);
    
        // Optionally, return the image URL
        if (isset($categoryData['image_url'])) {
            $category->image_url = asset('storage/' . $categoryData['image_url']);
        }
    
        // Return the created category as a JSON response
        return response()->json($category, 201);
    }

          

    public function update(Request $request, $cafe_id, $category_id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate as an image with specific mime types and max size
        ]);
    
        // Find the restaurant by ID
        $cafe = Cafe::findOrFail($cafe_id);
    
        // Find the category by ID
        $category = CafeCategory::where('cafe_id', $cafe->id)->findOrFail($category_id);
    
        // Prepare the data to be updated
        $categoryData = [
            'name' => $validatedData['name'],
        ];
    
        // Check if an image was uploaded
        if ($request->hasFile('image_url')) {
            // Store the new image in the 'public/restaurant' directory
            $imagePath = $request->file('image_url')->store('cafe', 'public');
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
    // Find the restaurant by ID
    $cafeCategorie = CafeCategory::find($id);

    if (!$cafeCategorie) {
        return response()->json(['error' => 'Category not found.'], 404);
    }

    // Delete the cinema's image if it exists
    if ($cafeCategorie->image_url) {
        $imagePath = str_replace(asset('storage/'), '', $cafeCategorie->image_url);

        // Delete the image file from storage
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

  
    $cafeCategorie->delete();

    return response()->json(['message' => 'Category and associated data deleted successfully.'], 200);
}
}    