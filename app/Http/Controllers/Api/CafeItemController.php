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

        // Retrieve all menu items for the specified category
        $cafeItems = CafeItem::where('category_id', $category_id)->get();

        // Add the full image URL to each menu item
        foreach ($cafeItems as $cafeItem) {
            $cafeItem->image = asset('storage/' . $cafeItem->image);
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
            $cafeItem->image = asset('storage/' . $cafeItem->image);
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
                $imagePath = $request->file('image')->store('menu_images', 'public');
                $validatedData['image'] = $imagePath;
            }
    
            $cafeItem = CafeItem::create($validatedData);
            $cafeItem->image = asset('storage/' . $validatedData['image']);
    
            return response()->json($cafeItem, 201);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found.'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
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
    
            $category = CafeCategory::findOrFail($category_id);
            $cafeItem = CafeItem::findOrFail($id);
    
            if ($cafeItem->category_id != $category_id) {
                return response()->json(['error' => 'Cafe item does not belong to this category.'], 400);
            }
    
            if ($request->hasFile('image')) {
                if ($cafeItem->image && Storage::disk('public')->exists($cafeItem->image)) {
                    Storage::disk('public')->delete($cafeItem->image);
                }
    
                $imagePath = $request->file('image')->store('menu_images', 'public');
                $validatedData['image'] = $imagePath;
            }
    
            $cafeItem->update($validatedData);
            $cafeItem->image = asset('storage/' . $validatedData['image']);
    
            return response()->json($cafeItem, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Category or menu item not found.'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }
    

    public function destroy($id)
{
    try {
        $cafeItem = CafeItem::findOrFail($id);
        $cafeItem->delete();
        return response()->json(['message' => 'Cafe item deleted successfully.'], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Cafe item not found.'], 404);
    } catch (\Exception $e) {
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
            'image' => asset('storage/' . $cafeItem->image),
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