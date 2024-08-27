<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CafeRequest;
use App\Models\Cafe;
use App\Models\CafeBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File; 

class CafeController extends Controller
{
    
    public function index()
    {
    
    try {
        $cafes = Cafe::with(['categories'])->get();
    
        $cafes->each(function ($cafe) {
            $cafe->image_url = $cafe->image_url ? asset('storage/' . $cafe->image_url) : null;
        });
    
        return response()->json($cafes);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while retrieving cafes. Please try again later.'], 500);
    }
    } 


   

public function show($id)
{
    try {
        $cafe = Cafe::with(['categories.cafeItems'])->findOrFail($id);

        // Ensure the image URL is complete, as in the store method
        if ($cafe->image_url) {
            $cafe->image_url = asset('storage/' . $cafe->image_url);
        }

        // Transform the categories and cafe items to include the complete image URL
        $cafe->categories->each(function ($category) {
            $category->cafeItems->each(function ($item) {
                if ($item->image) {
                    $item->image_url = asset('storage/' . $item->image); // Assuming the image path is stored in the 'image' attribute
                }
            });
        });

        return response()->json($cafe, 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Cafe not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while retrieving the cafe. Please try again later.'], 500);
    }
}




    public function store(CafeRequest $request)
    {
    
    try {
        $data = $request->validated();
        $validatedData = $data; // Initialize validatedData

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('cafes', 'public');
            $validatedData['image_url'] = $imagePath;
        }

        $cafe = Cafe::create($validatedData);

        if (isset($validatedData['image_url'])) {
            $cafe->image_url = asset('storage/' . $validatedData['image_url']);
        }

        return response()->json($cafe, 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while creating the restaurant. Please try again later.'], 500);
    }
}


   // Update an existing cafe
public function update(CafeRequest $request, $id)
{
    try {
        $data = $request->validated();

        $cafe = Cafe::findOrFail($id);

        if ($request->hasFile('image_url')) {
            // Delete the old image if it exists
            $oldImagePath = str_replace('storage/', '', $cafe->image_url);
            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }

            // Store the new image and update the image_url in the data array
            $newImagePath = $request->file('image_url')->store('cafes', 'public');
            $data['image_url'] = $newImagePath;
        }

        // Update the cafe with the validated data
        $cafe->update($data);

        // Generate the full URL for the image to return in the response
        if (isset($data['image_url'])) {
            $cafe->image_url = asset('storage/' . $data['image_url']);
        }

        return response()->json($cafe, 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Cafe not found.'], 404);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while updating the cafe. Please try again later.'], 500);
    }
}

   

 public function destroy($id)
{
    try {
        $cafe = Cafe::findOrFail($id);

        if ($cafe->image_url) {
            $imagePath = str_replace(asset('storage/'), '', $cafe->image_url);

            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        if ($cafe->menu_qr_code) {
            $qrCodePath = str_replace(asset('storage/'), '', $cafe->menu_qr_code);

            if (Storage::disk('public')->exists($qrCodePath)) {
                Storage::disk('public')->delete($qrCodePath);
            }
        }

        $bookings = CafeBooking::where('cafe_id', $id)->get();
        foreach ($bookings as $booking) {
            if ($booking->qr_code_path) {
                $bookingQrCodePath = str_replace(asset('storage/'), '', $booking->qr_code_path);

                if (Storage::disk('public')->exists($bookingQrCodePath)) {
                    Storage::disk('public')->delete($bookingQrCodePath);
                }
            }
        }

        $cafe->delete();

        return response()->json(['message' => 'cafe and associated data deleted successfully.'], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'cafe not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while deleting the cafe. Please try again later.'], 500);
    }
}



public function generateQrCodeForCafe($id)
{
    try {
       $cafe = Cafe::with('categories.items')->findOrFail($id);

        $qrCodeData = [
            'restaurant_name' =>$cafe->name,
            'location' =>$cafe->location,
            'latitude' =>$cafe->latitude,
            'longitude' =>$cafe->longitude,
            'opening_time_from' =>$cafe->opening_time_from,
            'opening_time_to' =>$cafe->opening_time_to,
            'categories' =>$cafe->categories->map(function ($category) {
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

        $qrCodePath = 'qr_codes/cafe_' .$cafe->id . '.png';
        QrCode::format('png')
            ->size(300)
            ->generate($jsonQrData, $qrCodeDir . 'cafe_' .$cafe->id . '.png');

       $cafe->menu_qr_code = $qrCodePath;
       $cafe->save();

        return response()->json([
            'message' => 'QR code generated successfully',
            'qr_code_url' => asset('storage/' . $qrCodePath),
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Cafe not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred while generating the QR code. Please try again later.'], 500);
    }
}

    
}