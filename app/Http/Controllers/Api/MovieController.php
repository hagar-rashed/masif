<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Http\Requests\MovieRequest;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index()
    {
        try {
            $movies = Movie::all();

            // Return only the image path for image_url
            foreach ($movies as $movie) {
                $movie->image_url = $movie->image_url ? $movie->image_url : null;
            }

            return response()->json($movies, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while retrieving movies. Please try again later.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $movie = Movie::findOrFail($id);

            // Return only the image path for movie image_url
            $movie->image_url = $movie->image_url ? $movie->image_url : null;

            return response()->json($movie, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Movie not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while retrieving the movie. Please try again later.'], 500);
        }
    }

    public function store(MovieRequest $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validated();

            // Handle image upload if present
            if ($request->hasFile('image_url')) {
                $imagePath = $request->file('image_url')->store('movies', 'public');
                $validatedData['image_url'] = $imagePath;
            }

            $movie = Movie::create($validatedData);

            // Return only the image path
            $movie->image_url = isset($validatedData['image_url']) ? $validatedData['image_url'] : null;

            return response()->json($movie, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while creating the movie. Please try again later.'], 500);
        }
    }

    public function update(MovieRequest $request, $id)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validated();

            // Find the movie by ID
            $movie = Movie::findOrFail($id);

            // Check if a new image file is provided
            if ($request->hasFile('image_url')) {
                // Extract the image path from the existing URL
                $oldImagePath = $movie->image_url;

                // Delete the old image if it exists in the storage
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                // Store the new image and update the image URL in the data array
                $newImagePath = $request->file('image_url')->store('movies', 'public');
                $validatedData['image_url'] = $newImagePath;
            }

            // Update the movie with the new data
            $movie->update($validatedData);

            // Return only the image path
            $movie->image_url = $movie->image_url ? $movie->image_url : null;

            return response()->json($movie, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Movie not found.'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while updating the movie. Please try again later.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $movie = Movie::findOrFail($id);

            // Delete the movie's image if it exists
            if ($movie->image_url) {
                $imagePath = $movie->image_url;

                // Delete the image file from storage
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            $movie->delete();

            return response()->json(['message' => 'Movie and associated image deleted successfully.'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Movie not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while deleting the movie. Please try again later.'], 500);
        }
    }
}
