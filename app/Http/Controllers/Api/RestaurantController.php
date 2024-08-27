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
   
    public function index()
{
    try {
        $restaurants = Restaurant::with(['categories'])->get();
    
        $restaurants->each(function ($restaurant) {
            $restaurant->image_url = $restaurant->image_url ? asset('storage/' . $restaurant->image_url) : null;
        });
    
        return response()->json($restaurants);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while retrieving restaurants. Please try again later.'], 500);
    }
}
    

public function show($id)
{
    try {
        $restaurant = Restaurant::with(['categories'])->findOrFail($id);
        // Add the full image URL to the restaurant object
        $restaurant->image_url = $restaurant->image_url ? asset('storage/' . $restaurant->image_url) : null;
          
       
        return response()->json($restaurant, 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Restaurant not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while retrieving the restaurant. Please try again later.'], 500);
    }
}


public function store(RestaurantRequest $request)
{
    try {
        $data = $request->validated();
        $validatedData = $data; // Initialize validatedData

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('restaurants', 'public');
            $validatedData['image_url'] = $imagePath;
        }

        $restaurant = Restaurant::create($validatedData);

        if (isset($validatedData['image_url'])) {
            $restaurant->image_url = asset('storage/' . $validatedData['image_url']);
        }

        return response()->json($restaurant, 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while creating the restaurant. Please try again later.'], 500);
    }
}


   
public function update(RestaurantRequest $request, $id)
{
    try {
        $data = $request->validated();

        $restaurant = Restaurant::findOrFail($id);

        if ($request->hasFile('image_url')) {
            $oldImagePath = str_replace(asset('storage/'), '', $restaurant->image_url);

            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }

            $newImagePath = $request->file('image_url')->store('restaurants', 'public');
            $data['image_url'] = $newImagePath;
        }

        $restaurant->update($data);

       // Generate the full URL for the image to return in the response
       if (isset($data['image_url'])) {
        $restaurant->image_url = asset('storage/' . $data['image_url']);
    }
        return response()->json($restaurant, 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Restaurant not found.'], 404);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while updating the restaurant. Please try again later.'], 500);
    }
}


public function generateQrCodeForRestaurant($id)
{
    try {
        $restaurant = Restaurant::with('categories.items')->findOrFail($id);

        $qrCodeData = [
            'restaurant_name' => $restaurant->name,
            'location' => $restaurant->location,
            'latitude' => $restaurant->latitude,
            'longitude' => $restaurant->longitude,
            'opening_time_from' => $restaurant->opening_time_from,
            'opening_time_to' => $restaurant->opening_time_to,
            'categories' => $restaurant->categories->map(function ($category) {
                return [
                    'name' => $category->name,
                    'items' => $category->items->map(function ($item) {
                        return [
                            'name' => $item->name,
                            'description' => $item->description,
                            'price_before_discount' => $item->price_before_discount,
                            'price_after_discount' => $item->price_after_discount,
                            'calories' => $item->calories,
                            'rating' => $item->rating,
                            'purchase_rate' => $item->purchase_rate,
                            'preparation_time' => $item->preparation_time,
                        ];
                    })->toArray()
                ];
            })->toArray()
        ];

        $jsonQrData = json_encode($qrCodeData);

        $qrCodeDir = public_path('storage/qr_codes/');
        if (!File::exists($qrCodeDir)) {
            File::makeDirectory($qrCodeDir, 0755, true);
        }

        $qrCodePath = 'qr_codes/restaurant_' . $restaurant->id . '.png';
        QrCode::format('png')
            ->size(300)
            ->generate($jsonQrData, $qrCodeDir . 'restaurant_' . $restaurant->id . '.png');

        $restaurant->menu_qr_code = $qrCodePath;
        $restaurant->save();

        return response()->json([
            'message' => 'QR code generated successfully',
            'qr_code_url' => asset('storage/' . $qrCodePath),
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Restaurant not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while generating the QR code. Please try again later.'], 500);
    }
}

public function destroy($id)
{
    try {
        $restaurant = Restaurant::findOrFail($id);

        if ($restaurant->image_url) {
            $imagePath = str_replace(asset('storage/'), '', $restaurant->image_url);

            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        if ($restaurant->menu_qr_code) {
            $qrCodePath = str_replace(asset('storage/'), '', $restaurant->menu_qr_code);

            if (Storage::disk('public')->exists($qrCodePath)) {
                Storage::disk('public')->delete($qrCodePath);
            }
        }

        $bookings = RestaurantBooking::where('restaurant_id', $id)->get();
        foreach ($bookings as $booking) {
            if ($booking->qr_code_path) {
                $bookingQrCodePath = str_replace(asset('storage/'), '', $booking->qr_code_path);

                if (Storage::disk('public')->exists($bookingQrCodePath)) {
                    Storage::disk('public')->delete($bookingQrCodePath);
                }
            }
        }

        $restaurant->delete();

        return response()->json(['message' => 'Restaurant and associated data deleted successfully.'], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Restaurant not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while deleting the restaurant. Please try again later.'], 500);
    }
}



}