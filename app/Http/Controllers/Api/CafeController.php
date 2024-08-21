<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CafeRequest;
use App\Models\Cafe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\CafeItem;


class CafeController extends Controller
{
   // List all cafe with their menu items
   public function index()
   {
       $cafes = Cafe::with('cafeItems')->get();
       return response()->json($cafes);
   }

   // Show a specific cafe with its menu items
   public function show($id)
   {
       $cafe = Cafe::with('cafeItems')->findOrFail($id);
       if (!$cafe) {
           return response()->json(['message' => 'cafe not found'], 404);
       }
       return response()->json($cafe);
   }

   // Store a new cafe
   public function store(CafeRequest $request)
   {
       $data = $request->validated();
       if ($request->hasFile('image_url')) {
           $data['image_url'] = $request->file('image_url')->store('cafes', 'public');
       }

       $cafe = Cafe::create($data);
    
       return response()->json($cafe, 201);
   }

   // Update an existing cafe
   public function update(CafeRequest $request, $id)
   {
       $cafe = Cafe::find($id);
       if (!$cafe) {
           return response()->json(['error' => 'Cafe not found'], 404);
       }

       $data = $request->validated();
       if ($request->hasFile('image_url')) {
           $data['image_url'] = $request->file('image_url')->store('cafes', 'public');
       }
       $cafe->update($data);


       return response()->json([
           'message' => 'Cafe updated successfully',
           'restaurant' => $cafe
       ], 200);
   }

   // Delete a cafe
   public function destroy($id)
   {
       $cafe = Cafe::find($id);

       if (!$cafe) {
           return response()->json(['error' => 'Cafe not found.'], 404);
       }

       // Delete the associated QR code file from storage if it exists
       if ($cafe->menu_qr_code) {
           Storage::disk('public')->delete($cafe->menu_qr_code);
       }

       $cafe->delete();

       return response()->json(['message' => 'Cafe deleted successfully.'], 200);
   }

   // Generate QR codes for all menu items of a specific restaurant
   public function generateQrCodeForCafe($id)
   {
        // Fetch the restaurant with its menu items
    $cafe = Cafe::with('cafeItems')->find($id);

    // If the restaurant is not found, return a 404 error response
    if (!$cafe) {
        return response()->json(['error' => 'Cafe not found'], 404);
    }
       // Prepare data for the QR code
       $qrCodeData = [
           'cafe_name' =>$cafe->name,
           'location' =>$cafe->location,
           'latitude' =>$cafe->latitude,
           'longitude' =>$cafe->longitude,
           'opening_time_from' =>$cafe->opening_time_from,
           'opening_time_to' =>$cafe->opening_time_to,
           'menu_items' =>$cafe->cafeItems->map(function($item) {
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
   
      
           $qrCodePath = 'qr_codes/cafe_' . $cafe->id . '.png';
           QrCode::format('png')
               ->size(300)
               ->generate($jsonQrData, public_path($qrCodePath));
   
       // Save the QR code path in the cafe record (optional)
       $cafe->menu_qr_code = $qrCodePath;
       $cafe->save();
   
       return response()->json([
           'message' => 'QR code generated successfully',
           'qr_code_url' => asset('storage/' . $qrCodePath),
       ]);
   }
   public function getcafeItemsWithImage($id)
   {
       // Fetch the cafe with its menu items
       $cafe = Cafe::with('cafeItems')->find($id);
       
       if (!$cafe) {
           return response()->json(['message' => 'Restaurant not found'], 404);
       }

       // Prepare the data for response
       $cafeItems = $cafe->cafeItems->map(function ($item) {
           return [
               'name' => $item->name,
               'image' => $item->image ? asset('storage/' . $item->image) : null,
           ];
       });

       return response()->json([
           'restaurant' => $cafe->name,
           'menu_items' => $cafeItems,
       ]);
   }
}