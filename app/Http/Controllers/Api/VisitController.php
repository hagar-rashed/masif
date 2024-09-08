<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

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
            'visit_time_from' => 'required|date_format:Y-m-d H:i:s',
            'visit_time_to' => 'required|date_format:Y-m-d H:i:s',
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

            // Generate the QR code data
            $qrCodeData = json_encode([
                'visit_id' => $visit->id,
                'name' => $visit->name,
                'purpose_of_visit' => $visit->purpose_of_visit,
                'visit_time_from' => $visit->visit_time_from,
                'visit_time_to' => $visit->visit_time_to,
            ]);

            // Save the QR code image
            $qrCodePath = 'qrcodes/visit_' . $visit->id . '.png';
            Storage::disk('public')->put($qrCodePath, QrCode::format('png')->size(200)->generate($qrCodeData));

            // Update visit with QR code path
            $visit->qr_code_path = $qrCodePath;
            $visit->save();

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
            'visit_time_from' => 'required|date_format:Y-m-d H:i:s',
            'visit_time_to' => 'required|date_format:Y-m-d H:i:s',
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

    // public function validateQrCode($visitId)
    // {
    //     try {
    //         $visit = Visit::findOrFail($visitId);
    
    //         $currentTime = Carbon::now('UTC');
    //         $visitEndTime = Carbon::createFromFormat('Y-m-d H:i:s', $visit->visit_time_to,'UTC');
    
    //         // Check if the current time is past the visit end time
    //         if ($currentTime->greaterThan($visitEndTime)) {
    //             return response()->json(['error' => 'QR code has expired.'], 400);
    //         }
    
    //         return response()->json(['message' => 'QR code is valid.', 'data' => $visit], 200);
    //     } catch (ModelNotFoundException $e) {
    //         return response()->json(['error' => 'Visit not found.'], 404);
    //     } catch (Exception $e) {
    //         // Log the error details
    //         \Log::error('Failed to validate QR code: ' . $e->getMessage());
    //         return response()->json(['error' => 'Failed to validate QR code.'], 500);
    //     }
    // }

    public function validateQrCode($visitId)
{
    try {
        
        $visit = Visit::findOrFail($visitId);

        // Get the current time in UTC
        $currentTime = Carbon::now('UTC');

        // Parse the visit end time as a Carbon instance
        $visitEndTime = Carbon::parse($visit->visit_time_to, 'UTC');

        // Check if the current time is after the visit end time
        if ($currentTime->greaterThan($visitEndTime)) {
            return response()->json(['error' => 'QR code has expired.'], 400);
        }

        // If the QR code is valid, return a success response with visit data
        return response()->json(['message' => 'QR code is valid.', 'data' => $visit], 200);

    } catch (ModelNotFoundException $e) {
        // Return a 404 error if the visit is not found
        return response()->json(['error' => 'Visit not found.'], 404);
    } catch (Exception $e) {
        // Log the exception details for troubleshooting
        \Log::error('Failed to validate QR code: ' . $e->getMessage());
        
        // Return a 500 error if there is an unexpected exception
        return response()->json(['error' => 'Failed to validate QR code.'], 500);
    }
}

    


  

}
