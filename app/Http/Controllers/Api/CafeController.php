<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cafe;
use App\Http\Requests\RestaurantRequest;

use Illuminate\Http\Response;

class CafeController extends Controller
{
    public function index()
    {
        $cafes = Cafe::all();
        return response()->json($cafes);
    }

    public function show($id)
    {
       $cafe = Cafe::find($id);
        if (!$cafe) {
            return response()->json(['message' => 'Cafe not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($cafe);
    }

    public function store(RestaurantRequest $request)
{
    $data = $request->validated();
    if ($request->hasFile('image_url')) {
        $data['image_url'] = $request->file('image_url')->store('cafes', 'public');
    }
   $cafe = Cafe::create($data);
    return response()->json($cafe, Response::HTTP_CREATED);
}

 function update(RestaurantRequest $request, $id)
{
   $cafe = Cafe::find($id);
    if (!$cafe) {
        return response()->json(['message' => 'Cafe not found'], Response::HTTP_NOT_FOUND);
    }
    
    $data = $request->validated();
    if ($request->hasFile('image_url')) {
        $data['image_url'] = $request->file('image_url')->store('cafes', 'public');
    }
   $cafe->update($data);
    return response()->json($cafe);
}

    public function destroy($id)
    {
       $cafe = Cafe::find($id);
        if (!$cafe) {
            return response()->json(['message' => 'Cafe not found'], Response::HTTP_NOT_FOUND);
        }
       $cafe->delete();
        return response()->json(['message' => 'Cafe deleted']);
    }
}
