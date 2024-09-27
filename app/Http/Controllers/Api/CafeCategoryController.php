<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cafe;
use App\Models\CafeCategory;
use App\Models\CafeItem;
use Illuminate\Support\Facades\Storage;



class CafeCategoryController extends Controller
{

 
    public function index($id)
    {
        try {
            // Get categories for the cafe
            $cafeCategories = CafeCategory::where('cafe_id', $id)->get();
            
            // Loop through each category and set the image URL to just the file path
            foreach ($cafeCategories as $category) {
                $category->image_url = $category->image_url ? $category->image_url : null;  // Return only the path, not the full URL
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
        $cafeCategory->image_url = $cafeCategory->image_url ? $cafeCategory->image_url : null;  // Return only the path, not the full URL

        $cafe->image_url = $cafe->image_url ? '' . $cafe->image_url : null;

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
           // $category->image_url = asset('storage/' . $categoryData['image_url']);
           $category->image_url = $category->image_url ? $category->image_url : null;  // Return only the path, not the full URL

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

    // Find the cafe by ID
    $cafe = Cafe::findOrFail($cafe_id);

    // Find the category by ID
    $category = CafeCategory::where('cafe_id', $cafe->id)->findOrFail($category_id);

    // Prepare the data to be updated
    $categoryData = [
        'name' => $validatedData['name'],
    ];

    // Check if an image was uploaded
    if ($request->hasFile('image_url')) {
        // Store the new image in the 'public/cafe' directory
        $imagePath = $request->file('image_url')->store('cafe', 'public');
        $categoryData['image_url'] = $imagePath;
    }

    // Update the category with the validated data
    $category->update($categoryData);

   
    $category->image_url = $category->image_url ? $category->image_url : null;  // Return only the path, not the full URL


    // Return the updated category as a JSON response
    return response()->json($category, 200);
}


 
// Delete a category and its image
public function destroy($id)
{
    // Find the category by ID
    $cafeCategory = CafeCategory::find($id);

    if (!$cafeCategory) {
        return response()->json(['error' => 'Category not found.'], 404);
    }

    // Delete the category's image if it exists
    if ($cafeCategory->image_url) {
        $imagePath = $cafeCategory->image_url;

        // Check if the image exists and delete it
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    // Delete the category
    $cafeCategory->delete();

    return response()->json(['message' => 'Category and associated data deleted successfully.'], 200);
}

}    