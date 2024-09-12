<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Other;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class OtherController extends Controller
{
    // Retrieve all records
    public function index()
    {
        try {
            $others = Other::all();
            return response()->json(['status' => 'success', 'data' => $others], 200);
        } catch (\Exception $e) {
            Log::error('Error retrieving records: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Unable to retrieve data'], 500);
        }
    }

    // Store a new record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image',
            'phone' => 'nullable|string',
            'latitude' => 'required|numeric',
           'longitude' => 'required|numeric',
            'location' => 'nullable|string',
            'description' => 'required|string',
            'opening_time_from' => 'required|string',
            'opening_time_to' => 'required|string',
            'delivery_time' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('others', 'public');
            }

            $other = Other::create($validated);

            return response()->json(['status' => 'success', 'data' => $other], 201);
        } catch (\Exception $e) {
            Log::error('Error creating record: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Unable to create record'], 500);
        }
    }

    // Retrieve a specific record
    public function show($id)
    {
        try {
            $other = Other::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $other], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error retrieving record: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Unable to retrieve record'], 500);
        }
    }

    // Update an existing record
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image',
            'phone' => 'nullable|string',
            'latitude' => 'nullable|numeric',
           'longitude' => 'nullable|numeric',
            'location' => 'nullable|string',
            'description' => 'required|string',
            'opening_time_from' => 'required|string',
            'opening_time_to' => 'required|string',
            'delivery_time' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        try {
            $other = Other::findOrFail($id);

            // Handle image upload
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('others', 'public');
            }

            $other->update($validated);

            return response()->json(['status' => 'success', 'data' => $other], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error updating record: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Unable to update record'], 500);
        }
    }

    // Delete a record
    public function destroy($id)
    {
        try {
            $other = Other::findOrFail($id);
            $other->delete();

            return response()->json(['status' => 'success', 'message' => 'Record deleted successfully'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting record: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Unable to delete record'], 500);
        }
    }
}
