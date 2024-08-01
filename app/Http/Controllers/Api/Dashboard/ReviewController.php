<?php

namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return response()->json($reviews);
    }
    public function store(Request $request)
    {
 
        $validatedData = $request->validate([
          
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
        ]);
        $review = Review::create($validatedData);

        return response()->json([
            'message' => 'review  created successfully.',
            'data' => $review
        ], 201);
    
    }
}
