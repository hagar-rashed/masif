<?php

namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\village;
use Illuminate\Http\Request;

class VallageController extends Controller{
    public function index()
    {
        $villages = village::all();
        return response()->json($villages);
    }

    public function store(Request $request)
    {
 
        $validatedData = $request->validate([
            'location_ar' => 'required|string|max:255',
            'location_en' => 'required|string|max:255',
            'lat' => 'required|string|max:255',
            'lng' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'services_ar' => 'required|string|max:255',
            'services_en' => 'required|string|max:255',
            'owner_name_ar' => 'required|string|max:255',
            'owner_name_en' => 'required|string|max:255',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
        ]);
        $village = village::create($validatedData);

        return response()->json([
            'message' => 'village created successfully.',
            'data' => $village
        ], 201);
    
    }

    public function show($id)
    {
        $village = Village::findOrFail($id);
        return response()->json($village);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'location_ar' => 'required|string|max:255',
            'location_en' => 'required|string|max:255',
            'lat' => 'required|string|max:255',
            'lng' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'services_ar' => 'required|string|max:255',
            'services_en' => 'required|string|max:255',
            'owner_name_ar' => 'required|string|max:255',
            'owner_name_en' => 'required|string|max:255',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
        ]);

       $village = Village::findOrFail($id);
       $village->update($validatedData);

        return response()->json([
            'message' => 'village updated successfully.',
            'data' =>$village
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
       $village = Village::findOrFail($id);
       $village->delete();

        return response()->json(['message' => 'village deleted successfully']);
    }
}

