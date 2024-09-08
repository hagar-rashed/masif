<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OwnerUnit;
use App\Models\OwnerUnitImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OwnerUnitController extends Controller
{
    public function index()
    {
        try {
            $userId = auth()->id(); // Get the ID of the currently authenticated user
            
            // Retrieve units for the authenticated user
            $units = OwnerUnit::where('user_id', $userId)->with('images')->get();
            
            return response()->json($units, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve units', 'details' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $userId = auth()->id(); // Get the ID of the currently authenticated user
            
            // Retrieve the unit for the authenticated user
            $unit = OwnerUnit::where('user_id', $userId)->with('images')->findOrFail($id);
            
            $this->formatImagePaths($unit);
            return response()->json($unit, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Unit not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve unit', 'details' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_type' => 'required|string|in:Chalet,Villa,Apartment',
            'unit_area' => 'required|string',
            'location' => 'required|string',
            'number_of_rooms' => 'required|integer',
            'contact_number' => 'required|string',
            'available_entertainment' => 'nullable|string',
            'number_of_beds' => 'required|integer',
            'price' => 'required|numeric',
            'details' => 'nullable|string',
            'payment_methods' => 'nullable|array',
            'payment_methods.*' => 'in:Visa,MasterCard,Vodafone,Etisalat,Orange',
            'pets_available' => 'required|boolean',
            'add_code_to_telephone' => 'required|boolean',
            'photos' => 'nullable|array',
            'photos.*' => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'panorama_images' => 'nullable|array',
            'panorama_images.*' => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $userId = auth()->id(); // Get the ID of the currently authenticated user

            $unit = OwnerUnit::create(array_merge(
                $request->except(['photos', 'panorama_images']),
                ['payment_methods' => json_encode($request->input('payment_methods', [])), 'user_id' => $userId]
            ));

            $this->storeImages($request, $unit);

            $unit->load('images');
            $this->formatImagePaths($unit);

            return response()->json($unit, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create unit', 'details' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'unit_type' => 'required|string|in:Chalet,Villa,Apartment',
            'unit_area' => 'required|string',
            'location' => 'required|string',
            'number_of_rooms' => 'required|integer',
            'contact_number' => 'required|string',
            'available_entertainment' => 'nullable|string',
            'number_of_beds' => 'required|integer',
            'price' => 'required|numeric',
            'details' => 'nullable|string',
            'payment_methods' => 'nullable|array',
            'payment_methods.*' => 'in:Visa,MasterCard,Vodafone,Etisalat,Orange',
            'pets_available' => 'required|boolean',
            'add_code_to_telephone' => 'required|boolean',
            'photos' => 'nullable|array',
            'photos.*' => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'panorama_images' => 'nullable|array',
            'panorama_images.*' => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $userId = auth()->id(); // Get the ID of the currently authenticated user

            $unit = OwnerUnit::where('user_id', $userId)->findOrFail($id);
            $unit->update(array_merge(
                $request->except(['photos', 'panorama_images']),
                ['payment_methods' => json_encode($request->input('payment_methods', []))]
            ));

            $this->storeImages($request, $unit);

            $unit->load('images');
            $this->formatImagePaths($unit);

            return response()->json($unit, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Unit not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update unit', 'details' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $userId = auth()->id(); // Get the ID of the currently authenticated user

            $unit = OwnerUnit::where('user_id', $userId)->findOrFail($id);

            // Delete associated images from storage and database
            foreach ($unit->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            // Delete the unit itself
            $unit->delete();

            return response()->json(['message' => 'Unit deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Unit not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete unit', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Store uploaded images and associate them with the OwnerUnit.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OwnerUnit $unit
     * @return void
     */
    private function storeImages(Request $request, OwnerUnit $unit)
    {
        try {
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('/photos', 'public');
                    OwnerUnitImage::create([
                        'owner_unit_id' => $unit->id,
                        'image_path' => $path,
                    ]);
                }
            }

            if ($request->hasFile('panorama_images')) {
                foreach ($request->file('panorama_images') as $panoramaImage) {
                    $path = $panoramaImage->store('/panorama', 'public');
                    OwnerUnitImage::create([
                        'owner_unit_id' => $unit->id,
                        'image_path' => $path,
                    ]);
                }
            }
        } catch (\Exception $e) {
            throw new \Exception('Failed to store images: ' . $e->getMessage());
        }
    }

    /**
     * Format image paths to remove the 'public/' prefix.
     *
     * @param \App\Models\OwnerUnit $unit
     * @return void
     */
    private function formatImagePaths(OwnerUnit $unit)
    {
        foreach ($unit->images as $image) {
            $image->image_path = str_replace('public/', '', $image->image_path);
        }
    }

    public function ownerUnits()
    {
        try {
            $userId = auth()->id(); // Get the ID of the currently authenticated user
            
            // Retrieve units for the authenticated user
            $units = OwnerUnit::where('user_id', $userId)->with('images')->get();
            
            return response()->json($units, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve units', 'details' => $e->getMessage()], 500);
        }
    }
}
