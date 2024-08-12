<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();
        return response()->json($restaurants);
    }

    public function show($id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($restaurant);
    }

    public function store(RestaurantRequest $request)
{
    $data = $request->validated();
    if ($request->hasFile('image_url')) {
        $data['image_url'] = $request->file('image_url')->store('restaurants', 'public');
    }
    $restaurant = Restaurant::create($data);
    return response()->json($restaurant, Response::HTTP_CREATED);
}

 function update(RestaurantRequest $request, $id)
{
    $restaurant = Restaurant::find($id);
    if (!$restaurant) {
        return response()->json(['message' => 'Restaurant not found'], Response::HTTP_NOT_FOUND);
    }
    
    $data = $request->validated();
    if ($request->hasFile('image_url')) {
        $data['image_url'] = $request->file('image_url')->store('restaurants', 'public');
    }
    $restaurant->update($data);
    return response()->json($restaurant);
}

    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], Response::HTTP_NOT_FOUND);
        }
        $restaurant->delete();
        return response()->json(['message' => 'Restaurant deleted']);
    }
}
