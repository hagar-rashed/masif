<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class VisitController extends Controller
{ 
    public function index()
    {
        try {
            $visits = Visit::all();
            return response()->json($visits, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve visits.'], 500);
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized. Please log in.'], 401);
        }

        if ($user->user_type !== 'owner') {
            return response()->json(['error' => 'Forbidden, only owners can create visits.'], 403);
        }

        $validatedData = $request->validate([
            'postulant_type' => 'required|in:tenant,visitor',
            'name' => 'required|string|max:255',
            'purpose_of_visit' => 'required|string',
            'number_of_individuals' => 'required|integer|min:1',
            'visit_time_from' => 'required|date_format:H:i',
            'visit_time_to' => 'required|date_format:H:i',
            'duration_of_visit' => 'required|string',
            'pets' => 'boolean',
            'pet_type' => 'nullable|string',
            'entry_by_vehicle' => 'boolean',
            'vehicle_type' => 'nullable|string',
            'accompanying_individuals' => 'nullable|integer|min:0',
        ]);

        try {
            $validatedData['user_id'] = $user->id;
            $visit = Visit::create($validatedData);

            return response()->json(['message' => 'Visit created successfully.', 'data' => $visit], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create visit.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $visit = Visit::findOrFail($id);
            return response()->json($visit, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Visit not found.'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve visit.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'postulant_type' => 'required|in:tenant,visitor',
            'name' => 'required|string|max:255',
            'purpose_of_visit' => 'required|string',
            'number_of_individuals' => 'required|integer|min:1',
            'visit_time_from' => 'required|date_format:H:i',
            'visit_time_to' => 'required|date_format:H:i',
            'duration_of_visit' => 'required|string',
            'pets' => 'boolean',
            'pet_type' => 'nullable|string',
            'entry_by_vehicle' => 'boolean',
            'vehicle_type' => 'nullable|string',
            'accompanying_individuals' => 'nullable|integer|min:0',
        ]);

        try {
            $visit = Visit::findOrFail($id);
            $visit->update($validatedData);

            return response()->json(['message' => 'Visit updated successfully.', 'data' => $visit], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Visit not found.'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update visit.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $visit = Visit::findOrFail($id);
            $visit->delete();

            return response()->json(['message' => 'Visit deleted successfully.'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Visit not found.'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete visit.'], 500);
        }
    }
}
