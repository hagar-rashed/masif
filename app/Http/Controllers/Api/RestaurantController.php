<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRequest;
use App\Models\Restaurant;
use App\Models\RestaurantBooking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\MenuItem;
use Illuminate\Support\Facades\File;


class RestaurantController extends Controller
{
   // List all restaurants with their menu items
   public function index()
   {
    
    // Fetch all restaurants with their menu items
    $restaurants = Restaurant::with('menuItems')->get();

    // Map over each restaurant and its menu items to add the full image URL
    $restaurants = $restaurants->map(function ($restaurant) {
        $restaurant->menuItems = $restaurant->menuItems->map(function ($menuItem) {
            // Construct the full image URL
            $menuItem->image = $menuItem->image ? asset('storage/' . $menuItem->image) : null;
            return $menuItem;
        });
        return $restaurant;
    });

    // Return the response as JSON
    return response()->json($restaurants);
   }

   
   // Show a specific restaurant with its menu items
   public function show($id)
   {
       // Fetch the specific restaurant with its menu items
       $restaurant = Restaurant::with('menuItems')->find($id);
   
       // Check if the restaurant exists
       if (!$restaurant) {
           return response()->json(['message' => 'Restaurant not found'], 404);
       }
   
       // Map over the menu items to include the full image URL
       $restaurant->menuItems = $restaurant->menuItems->map(function ($menuItem) {
           // Construct the full image URL
           $menuItem->image = $menuItem->image ? asset('storage/' . $menuItem->image) : null;
           return $menuItem;
       });
   
       // Return the response as JSON
       return response()->json($restaurant);
   }
   


   public function store(RestaurantRequest $request)
   {
       // Validate the incoming request data
       $data = $request->validated();
       $validatedData = $data; // Initialize validatedData
   
       // Handle image upload if present
       if ($request->hasFile('image_url')) {
           $imagePath = $request->file('image_url')->store('restaurants', 'public');
           $validatedData['image_url'] = $imagePath;
       }
   
       // Create the restaurant with validated data
       $restaurant = Restaurant::create($validatedData);
   
       // Optionally, return the image URL
       if (isset($validatedData['image_url'])) {
           $restaurant->image_url = asset('storage/' . $validatedData['image_url']);
       }
   
       return response()->json($restaurant, 201);
   }
   


   
public function update(RestaurantRequest $request, $id)
{
    // Validate the incoming request data
    $data = $request->validated();

    // Find the restaurant by ID
    $restaurant = Restaurant::findOrFail($id);

    // Check if a new image file is provided
    if ($request->hasFile('image_url')) {
        // Extract the image path from the existing URL
        $oldImagePath = str_replace(asset('storage/'), '', $restaurant->image_url);

        // Delete the old image if it exists in the storage
        if (Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

        // Store the new image and update the image URL in the data array
        $newImagePath = $request->file('image_url')->store('restaurants', 'public');
        $data['image_url'] = $newImagePath;
    }

    // Update the restaurant with the new data
    $restaurant->update($data);

    // Update the image URL with the public path
    $restaurant->image_url = asset('storage/' . $restaurant->image_url);
    $restaurant->save();

    return response()->json($restaurant, 200);
}


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
   
       // Ensure the directory exists
       $qrCodeDir = public_path('storage/qr_codes/');
       if (!File::exists($qrCodeDir)) {
           File::makeDirectory($qrCodeDir, 0755, true);
       }
   
       // Generate the QR code and save it to a file
       $qrCodePath = 'qr_codes/restaurant_' . $restaurant->id . '.png';
       QrCode::format('png')
           ->size(300)
           ->generate($jsonQrData, $qrCodeDir . 'restaurant_' . $restaurant->id . '.png');
   
       // Save the QR code path in the restaurant record (optional)
       $restaurant->menu_qr_code = $qrCodePath;
       $restaurant->save();
   
       // Return the QR code URL in the response
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
            'image' => $item->image ?  asset('storage/' . $item->image) : null,    // The full URL is already stored
        ];
    });

    return response()->json([
        'restaurant' => $restaurant->name,
        'menu_items' => $menuItems,
    ]);
}

public function destroy($id)
{
    // Find the restaurant by ID
    $restaurant = Restaurant::find($id);

    if (!$restaurant) {
        return response()->json(['error' => 'Restaurant not found.'], 404);
    }

    // Delete the restaurant's image if it exists
    if ($restaurant->image_url) {
        $imagePath = str_replace(asset('storage/'), '', $restaurant->image_url);

        // Delete the image file from storage
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    // Delete the restaurant's QR code if it exists
    if ($restaurant->menu_qr_code) {
        $qrCodePath = str_replace(asset('storage/'), '', $restaurant->menu_qr_code);

        // Delete the QR code file from storage
        if (Storage::disk('public')->exists($qrCodePath)) {
            Storage::disk('public')->delete($qrCodePath);
        }
    }

    // Find and delete related booking QR codes
    $bookings = RestaurantBooking::where('restaurant_id', $id)->get();
    foreach ($bookings as $booking) {
        if ($booking->qr_code_path) {
            $bookingQrCodePath = str_replace(asset('storage/'), '', $booking->qr_code_path);

            // Delete the booking QR code file from storage
            if (Storage::disk('public')->exists($bookingQrCodePath)) {
                Storage::disk('public')->delete($bookingQrCodePath);
            }
        }
    }

    // Find and delete related menu item images
    $menuItems = $restaurant->menuItems; // Load related menu items
    foreach ($menuItems as $menuItem) {
        if ($menuItem->image) {
            $menuItemImagePath = str_replace(asset('storage/'), '', $menuItem->image);

            // Delete the menu item image file from storage
            if (Storage::disk('public')->exists($menuItemImagePath)) {
                Storage::disk('public')->delete($menuItemImagePath);
            }
        }
    }

    // Delete the restaurant record
    $restaurant->delete();

    return response()->json(['message' => 'Restaurant and associated data deleted successfully.'], 200);
}



}