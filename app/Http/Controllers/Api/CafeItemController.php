<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CafeItem;
use App\Models\Cafe;


class CafeItemController extends Controller
{
   
     // List all menu items
     public function index()
     {
         $cafeItems = CafeItem::all();
         return response()->json($cafeItems);
     }
 
     // Show a specific menu item
     public function show($id)
     {
         $cafeItem= CafeItem::findOrFail($id);
         return response()->json($cafeItem);
     }
 
     // Create a new menu item
     public function store(Request $request)
     {
         $validatedData = $request->validate([
             'cafe_id' => 'required|exists:cafes,id', 
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
 
         $cafeItem= CafeItem::create($validatedData);        
 
         return response()->json($cafeItem, 201);
     }
 
    
   
     public function update(Request $request, $id)
 {
     // Find the menu item by ID or return null if not found
     $cafeItem= CafeItem::find($id);
 
     // Check if the menu item was found
     if (!$cafeItem) {
         return response()->json(['error' => 'Cafe item not found'], 404);
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
     'message' => 'Cafe  item updated successfully',
     'menuItem' => $cafeItem
   ], 200);
 }
 
 
    
     public function destroy($id)
     {
         $cafeItem= CafeItem::find($id);
     
         if (!$menuItem) {
             return response()->json(['error' => 'Menu item not found.'], 404);
         }
     
         $menuItem->delete();
     
         return response()->json(['message' => 'Menu item deleted successfully.'], 200);
     }
 
     
     public function addToCart(Request $request)
     {
         $request->validate([
             'cafe_item_id' => 'required|exists:menu_items,id',
             'quantity' => 'required|integer|min:1', // Corrected validation rule
         ]);
     
         // Fetch the menu item
         $cafeItem= MenuItem::find($request->cafe_item_id);
     
         // Calculate total price
         $totalPrice = $cafeItem->price_after_discount * $request->quantity;
     
         // Prepare the data for response
         $cartItem = [
             'name' => $cafeItem->name,
             'image' => asset('storage/' . $cafeItem->image),
             'quantity' => $request->quantity,
             'price_before_discount' => $cafeItem->price_before_discount,
             'price_after_discount' => $cafeItem->price_after_discount,
             'total_price' => $totalPrice,
             'preparation_time' => $cafeItem->preparation_time,
         ];
     
         return response()->json([
             'message' => 'Item added to cart successfully',
             'cart_item' => $cartItem,
         ]);
     }
     
 }
     
 