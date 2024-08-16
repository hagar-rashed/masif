<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\MenuItem;


class RestaurantController extends Controller
{
   // List all restaurants with their menu items
   public function index()
   {
       $restaurants = Restaurant::with('menuItems')->get();
       return response()->json($restaurants);
   }

   // Show a specific restaurant with its menu items
   public function show($id)
   {
       $restaurant = Restaurant::with('menuItems')->findOrFail($id);
       if (!$restaurant) {
           return response()->json(['message' => 'Restaurant not found'], 404);
       }
       return response()->json($restaurant);
   }

   // Store a new restaurant
   public function store(RestaurantRequest $request)
   {
       $data = $request->validated();
       if ($request->hasFile('image_url')) {
           $data['image_url'] = $request->file('image_url')->store('restaurants', 'public');
       }

       $restaurant = Restaurant::create($data);
    
       return response()->json($restaurant, 201);
   }

   // Update an existing restaurant
   public function update(RestaurantRequest $request, $id)
   {
       $restaurant = Restaurant::find($id);
       if (!$restaurant) {
           return response()->json(['error' => 'Restaurant not found'], 404);
       }

       $data = $request->validated();
       if ($request->hasFile('image_url')) {
           $data['image_url'] = $request->file('image_url')->store('restaurants', 'public');
       }
       $restaurant->update($data);


       return response()->json([
           'message' => 'Restaurant updated successfully',
           'restaurant' => $restaurant
       ], 200);
   }

   // Delete a restaurant
   public function destroy($id)
   {
       $restaurant = Restaurant::find($id);

       if (!$restaurant) {
           return response()->json(['error' => 'Restaurant not found.'], 404);
       }

       // Delete the associated QR code file from storage if it exists
       if ($restaurant->menu_qr_code) {
           Storage::disk('public')->delete($restaurant->menu_qr_code);
       }

       $restaurant->delete();

       return response()->json(['message' => 'Restaurant deleted successfully.'], 200);
   }

   // Generate QR codes for all menu items of a specific restaurant
   public function generateQrCodeForRestaurant($id)
   {
        // Fetch the restaurant with its menu items
    $restaurant = Restaurant::with('menuItems')->find($id);

    // If the restaurant is not found, return a 404 error response
    if (!$restaurant) {
        return response()->json(['error' => 'Restaurant not found'], 404);
    }
       // Prepare data for the QR code
       $qrCodeData = [
           'restaurant_name' => $restaurant->name,
           'location' => $restaurant->location,
           'latitude' => $restaurant->latitude,
           'longitude' => $restaurant->longitude,
           'opening_time_from' => $restaurant->opening_time_from,
           'opening_time_to' => $restaurant->opening_time_to,
           'menu_items' => $restaurant->menuItems->map(function($item) {
               return [
                   'name' => $item->name,
                   'description' => $item->description,
                   'price' => $item->price,
                   'calories' => $item->calories,
                   'rating' => $item->rating,
                   'purchase_rate' => $item->purchase_rate,
                   'preparation_time' => $item->preparation_time,
               ];
           })->toArray()
       ];
   
       // Convert the data to JSON format
       $jsonQrData = json_encode($qrCodeData);
   
      
           $qrCodePath = 'qr_codes/restaurant_' . $restaurant->id . '.png';
           QrCode::format('png')
               ->size(300)
               ->generate($jsonQrData, public_path($qrCodePath));
   
       // Save the QR code path in the restaurant record (optional)
       $restaurant->menu_qr_code = $qrCodePath;
       $restaurant->save();
   
       return response()->json([
           'message' => 'QR code generated successfully',
           'qr_code_url' => asset('storage/' . $qrCodePath),
       ]);
   }
   public function getMenuItemsWithImage($id)
   {
       // Fetch the restaurant with its menu items
       $restaurant = Restaurant::with('menuItems')->find($id);
       
       if (!$restaurant) {
           return response()->json(['message' => 'Restaurant not found'], 404);
       }

       // Prepare the data for response
       $menuItems = $restaurant->menuItems->map(function ($item) {
           return [
               'name' => $item->name,
               'image' => $item->image ? asset('storage/' . $item->image) : null,
           ];
       });

       return response()->json([
           'restaurant' => $restaurant->name,
           'menu_items' => $menuItems,
       ]);
   }
}