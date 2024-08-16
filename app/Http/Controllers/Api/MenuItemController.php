<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    // List all menu items
    public function index()
    {
        $menuItems = MenuItem::all();
        return response()->json($menuItems);
    }

    // Show a specific menu item
    public function show($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        return response()->json($menuItem);
    }

    // Create a new menu item
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id', 
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_before_discount' => 'required|numeric',
            'price_after_discount' => 'required|numeric',
            'calories' => 'required|in:150 kal,200 kal,300 kal',
            'image' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:5',
            'purchase_rate' => 'required|numeric|min:0|max:5',
            'preparation_time' => 'required',
        ]); 

        $menuItem = MenuItem::create($validatedData);        

        return response()->json($menuItem, 201);
    }

   
  
    public function update(Request $request, $id)
{
    // Find the menu item by ID or return null if not found
    $menuItem = MenuItem::find($id);

    // Check if the menu item was found
    if (!$menuItem) {
        return response()->json(['error' => 'Menu item not found'], 404);
    }

    // Validate request data
    $validatedData = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'description' => 'nullable|string',
        'price_before_discount' => 'sometimes|required|numeric',
        'price_after_discount' => 'sometimes|required|numeric',
        'calories' => 'sometimes|required|in:150 kal,200 kal,300 kal',
        'image' => 'nullable|string',
        'rating' => 'sometimes|required|numeric|min:0|max:5',
        'purchase_rate' => 'sometimes|required|numeric|min:0|max:5',
        'preparation_time' => 'sometimes|required|integer',
    ]);

    // Update the menu item with validated data
    $menuItem->update($validatedData);

    // Return the updated menu item
  //  return response()->json($menuItem, 200);
  return response()->json([
    'message' => 'Menu item updated successfully',
    'menuItem' => $menuItem
  ], 200);
}


   
    public function destroy($id)
    {
        $menuItem = MenuItem::find($id);
    
        if (!$menuItem) {
            return response()->json(['error' => 'Menu item not found.'], 404);
        }
    
        $menuItem->delete();
    
        return response()->json(['message' => 'Menu item deleted successfully.'], 200);
    }

    
    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1', // Corrected validation rule
        ]);
    
        // Fetch the menu item
        $menuItem = MenuItem::find($request->menu_item_id);
    
        // Calculate total price
        $totalPrice = $menuItem->price_after_discount * $request->quantity;
    
        // Prepare the data for response
        $cartItem = [
            'name' => $menuItem->name,
            'image' => asset('storage/' . $menuItem->image),
            'quantity' => $request->quantity,
            'price_before_discount' => $menuItem->price_before_discount,
            'price_after_discount' => $menuItem->price_after_discount,
            'total_price' => $totalPrice,
            'preparation_time' => $menuItem->preparation_time,
        ];
    
        return response()->json([
            'message' => 'Item added to cart successfully',
            'cart_item' => $cartItem,
        ]);
    }
    
}
    
