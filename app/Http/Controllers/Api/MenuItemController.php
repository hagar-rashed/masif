<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\RestaurantCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    
    public function index($category_id)
    {
        try {
            // Check if the category exists
            $category = RestaurantCategory::findOrFail($category_id);
    
            // Retrieve all menu items for the specified category
            $menuItems = MenuItem::where('category_id', $category_id)->get();
    
            // Add the full image URL to each menu item
            foreach ($menuItems as $menuItem) {
                $menuItem->image = asset('storage/' . $menuItem->image);
            }
    
            return response()->json($menuItems);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }
    


    public function show($id)
    {
        try {
            $menuItem = MenuItem::findOrFail($id);
            $menuItem->image = asset('storage/' . $menuItem->image);
            return response()->json($menuItem);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Menu item not found.'], 404);
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

        $category = RestaurantCategory::findOrFail($category_id);
        $validatedData['category_id'] = $category_id;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $menuItem = MenuItem::create($validatedData);
        $menuItem->image = asset('storage/' . $validatedData['image']);

        return response()->json($menuItem, 201);
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

        $category = RestaurantCategory::findOrFail($category_id);
        $menuItem = MenuItem::findOrFail($id);

        if ($menuItem->category_id != $category_id) {
            return response()->json(['error' => 'Menu item does not belong to this category.'], 400);
        }

        if ($request->hasFile('image')) {
            if ($menuItem->image && Storage::disk('public')->exists($menuItem->image)) {
                Storage::disk('public')->delete($menuItem->image);
            }

            $imagePath = $request->file('image')->store('menu_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $menuItem->update($validatedData);
        $menuItem->image = asset('storage/' . $validatedData['image']);

        return response()->json($menuItem, 200);
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
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->delete();
        return response()->json(['message' => 'Menu item deleted successfully.'], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Menu item not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
    }
}

    
public function addToCart(Request $request)
{
    try {
        $validatedData = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $menuItem = MenuItem::findOrFail($validatedData['menu_item_id']);
        $totalPrice = $menuItem->price_after_discount * $validatedData['quantity'];

        $cartItem = [
            'name' => $menuItem->name,
            'image' => asset('storage/' . $menuItem->image),
            'quantity' => $validatedData['quantity'],
            'price_before_discount' => $menuItem->price_before_discount,
            'price_after_discount' => $menuItem->price_after_discount,
            'total_price' => $totalPrice,
            'preparation_time' => $menuItem->preparation_time,
        ];

        return response()->json([
            'message' => 'Item added to cart successfully',
            'cart_item' => $cartItem,
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Menu item not found.'], 404);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
    }
}

    
}
    
