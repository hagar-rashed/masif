<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cinema;
use App\Http\Requests\CinemaRequest;
use Illuminate\Support\Facades\Storage;

class CinemaController extends Controller
{
    public function index()
    {
        try {
            $cinemas = Cinema::all();

            // Return only the image path without the full URL
            foreach ($cinemas as $cinema) {
                $cinema->image_url = $cinema->image_url ? $cinema->image_url : null;
            }

            return response()->json($cinemas, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while retrieving cinemas. Please try again later.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $cinema = Cinema::with('movies')->findOrFail($id);

            // Return only the cinema image path
            $cinema->image_url = $cinema->image_url ? $cinema->image_url : null;

            // Return only the movie image paths
            foreach ($cinema->movies as $movie) {
                $movie->image_url = $movie->image_url ? $movie->image_url : null;
            }

            return response()->json($cinema, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Cinema not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while retrieving the cinema. Please try again later.'], 500);
        }
    }

    public function store(CinemaRequest $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validated();
            $validatedData ['user_id'] = auth()->id(); // Assign the currently authenticated user's ID


            // Handle image upload if present
            if ($request->hasFile('image_url')) {
                $imagePath = $request->file('image_url')->store('cinemas', 'public');
                $validatedData['image_url'] = $imagePath;
            }

            $cinema = Cinema::create($validatedData);

            // Return only the image path
            $cinema->image_url = $validatedData['image_url'] ?? null;

            return response()->json($cinema, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while creating the cinema. Please try again later.'], 500);
        }
    }

    public function update(CinemaRequest $request, $id)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validated();

            // Find the cinema by ID
            $cinema = Cinema::findOrFail($id);

            if ($cinema->user_id !== auth()->id()) {
                return response()->json(['error' => 'Unauthorized action.'], 403);
            }

            // Check if a new image file is provided
            if ($request->hasFile('image_url')) {
                // Extract the image path from the existing URL
                $oldImagePath = $cinema->image_url;

                // Delete the old image if it exists in the storage
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                // Store the new image and update the image URL in the data array
                $newImagePath = $request->file('image_url')->store('cinemas', 'public');
                $validatedData['image_url'] = $newImagePath;
            }

            // Update the cinema with the new data
            $cinema->update($validatedData);

            // Return only the image path
            $cinema->image_url = $cinema->image_url;

            return response()->json($cinema, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Cinema not found.'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while updating the cinema. Please try again later.'], 500);
        }
    }



    public function destroy($id)
    {
        try {
            // Find the cinema by ID
            $cinema = Cinema::findOrFail($id);

            // Delete the cinema's image if it exists
            if ($cinema->image_url) {
                $imagePath = str_replace(asset('storage/'), '', $cinema->image_url);

                // Delete the image file from storage
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            $cinema->delete();

            return response()->json(['message' => 'Cinema and associated data deleted successfully.'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Cinema not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while deleting the cinema. Please try again later.'], 500);
        }
    }

    public function showMovies($id)
    {
        try {
            $cinema = Cinema::with('movies')->findOrFail($id);

            // Add the complete path for each movie's image_url
            foreach ($cinema->movies as $movie) {
                $movie->image_url = $movie->image_url ? $movie->image_url : null;

            }

            return response()->json($cinema->movies, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Cinema not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while retrieving the movies. Please try again later.'], 500);
        }
    }

   
}
