<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'desc_ar' => 'nullable|string',
            'desc_en' => 'nullable|string',
            'price' => 'required|numeric',
            'village_id' => 'required|exists:villages,id',
        ]);

        $service = Service::create($validatedData);

        return response()->json([
            'message' => 'Service created successfully.',
            'data' => $service
        ], 201);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name_ar' => 'sometimes|required|string|max:255',
            'name_en' => 'sometimes|required|string|max:255',
            'desc_ar' => 'nullable|string',
            'desc_en' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'village_id' => 'sometimes|required|exists:villages,id',
        ]);

        $service = Service::findOrFail($id);
        $service->update($validatedData);

        return response()->json([
            'message' => 'Service updated successfully.',
            'data' => $service
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
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(['message' => 'Service deleted successfully']);
    }
}
