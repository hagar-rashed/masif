<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CafeItem;
use App\Models\Cafe;
use App\Models\CafeCategory;
use Illuminate\Support\Facades\Storage;

class CafeItemController extends Controller
{
    
    public function index($category_id)
    {
        try {
            // Check if the category exists
            $category = CafeCategory::findOrFail($category_id);
    
            // Retrieve all cafe items for the specified category
            $cafeItems = CafeItem::where('category_id', $category_id)->get();
    
            // Format the image path for each cafe item
            foreach ($cafeItems as $cafeItem) {
                $cafeItem->image = str_replace('storage/', '', $cafeItem->image);
            }
    
            return response()->json($cafeItems);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }
    

    

public function show($id)
{
    try {
        $cafeItem = CafeItem::findOrFail($id);

        // Format the image path
        $cafeItem->image = str_replace('storage/', '', $cafeItem->image);

        return response()->json($cafeItem);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Cafe item not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
    }
}

    
    
   public function store(Request $request, $category_id)
{
    try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_before_discount' => 'required|numeric',
            'price_after_discount' => 'required|numeric',
            'calories' => 'required|in:150 kal,200 kal,300 kal',
            'image' => 'nullable|image',
            'rating' => 'required|numeric|min:0|max:5',
            'purchase_rate' => 'required|numeric|min:0|max:5',
            'preparation_time' => 'required',
        ]);

        $category = CafeCategory::findOrFail($category_id);
        $validatedData['category_id'] = $category_id;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cafe_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $cafeItem = CafeItem::create($validatedData);
        $cafeItem->image = '' . $validatedData['image']; // Updated to just return the path

        return response()->json($cafeItem, 201);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Category not found.'], 404);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
        return response()->json(['error' => 'Uploaded file is too large.'], 413);
    } catch (\Exception $e) {
        // Log the exception message for debugging
        \Log::error('Store Cafe Item Error: ' . $e->getMessage());
        return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
    }
}

public function update(Request $request, $category_id, $id)
{
    try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_before_discount' => 'required|numeric',
            'price_after_discount' => 'required|numeric',
            'calories' => 'required|in:150 kal,200 kal,300 kal',
            'image' => 'nullable|image',
            'rating' => 'required|numeric|min:0|max:5',
            'purchase_rate' => 'required|numeric|min:0|max:5',
            'preparation_time' => 'required',
        ]);

        // Check if the category exists
        $category = CafeCategory::findOrFail($category_id);
        
        // Find the cafe item by ID
        $cafeItem = CafeItem::findOrFail($id);

        // Check if the cafe item belongs to the specified category
        if ($cafeItem->category_id != $category_id) {
            return response()->json(['error' => 'Cafe item does not belong to this category.'], 400);
        }

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($cafeItem->image && Storage::disk('public')->exists($cafeItem->image)) {
                Storage::disk('public')->delete($cafeItem->image);
            }

            // Store the new image and update the path
            $imagePath = $request->file('image')->store('cafe_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Update the cafe item with the validated data
        $cafeItem->update($validatedData);

        // Update the image URL to be relative to the storage path
        $cafeItem->image = '' . ($validatedData['image'] ?? $cafeItem->image);

        return response()->json($cafeItem, 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Category or cafe item not found.'], 404);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
        return response()->json(['error' => 'Uploaded file is too large.'], 413);
    } catch (\Exception $e) {
        // Log the exception message for debugging
        \Log::error('Update Cafe Item Error: ' . $e->getMessage());
        return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
    }
}


public function addToCart(Request $request)
{
    try {
        $validatedData = $request->validate([
            'cafe_item_id' => 'required|exists:cafe_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cafeItem = CafeItem::findOrFail($validatedData['cafe_item_id']);
        $totalPrice = $cafeItem->price_after_discount * $validatedData['quantity'];

        $cartItem = [
            'name' => $cafeItem->name,
            'image' => $cafeItem->image,  // Return the image path without full URL
            'quantity' => $validatedData['quantity'],
            'price_before_discount' => $cafeItem->price_before_discount,
            'price_after_discount' => $cafeItem->price_after_discount,
            'total_price' => $totalPrice,
            'preparation_time' => $cafeItem->preparation_time,
        ];

        return response()->json([
            'message' => 'Item added to cart successfully',
            'cart_item' => $cartItem,
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Cafe item not found.'], 404);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
    }
}
}