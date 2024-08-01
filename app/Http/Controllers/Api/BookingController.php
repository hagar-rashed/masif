<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingCollection;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $booking = BookingResource::collection(Booking::all());
            return response()->json($booking);
        }catch(Exception $e){
            return response()->json([
                'status' => 'Failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show_one($id)
    {
        return Booking::with(['user', 'unit', 'trip'])->findOrFail($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            // 'price' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
            'unit_id' => 'nullable|exists:units,id',
            'trip_id' => 'nullable|exists:trips,id',
        ]);
        if (empty($request->unit_id) && empty($request->trip_id)) {
            return response()->json([
                'error' => 'You must choose either a unit or a trip.'
            ], 422);
        }
        if($request->unit_id){
            $units = unit::findOrFail($request->unit_id);
        
            if ($units->status === 1) {
                return response()->json(['message' => 'Unit is already booked.'], 400);
            }
            try {
                $booking = Booking::create([
                    'check_in' => $request->check_in,
                    'check_out' => $request->check_out,
                    // 'price' => $request->price,
                    'user_id' => $request->user_id,
                    'unit_id' => $request->unit_id,
                ]);
                $units->booked = 1;
                $units->save();
                return response()->json([
                    'message' => 'Booking Created Successfully.',
                    'status' => 'Success',
                    'booking' => new BookingResource($booking)
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => $e->getMessage()
                ]);
            }
        }else{
            try {
                $booking = Booking::create([
                    'check_in' => $request->check_in,
                    'check_out' => $request->check_out,
                    // 'price' => $request->price,
                    'user_id' => $request->user_id,
                    'trip_id' => $request->trip_id,
                ]);
                return response()->json([
                    'message' => 'Booking Created Successfully.',
                    'status' => 'Success',
                    'booking' => new BookingResource($booking)
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            // 'price' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
            'unit_id' => 'nullable|exists:units,id',
            'trip_id' => 'nullable|exists:trips,id',
        ]);
        $booking = Booking::findOrFail($id);
        try{
            $booking->update([
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                // 'price' => $request->price,
                'user_id' => $request->user_id,
                'unit_id' => $request->unit_id,
                'trip_id' => $request->trip_id,
                'status' => $request->status,
            ]);
            return response()->json([
                'message' => 'Booking updated successfully.',
                'status' => 'success',
                'booking' => new BookingResource($booking)
            ]);
        }catch (Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            if ($booking) {
                if($booking->unit != null){
                    $unit = $booking->unit;
                    $booking->delete();
                    $unit->booked = 0;
                    $unit->save();
                }
                $booking->delete();
                return response()->json([
                    'status' => 'Booking Deleted',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => $e->getMessage()
            ]);
        }
    }
}
