<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\unit;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{

    public function index()
    {
        $bookings = Booking::all();
        return view('dashboard.booking.index', compact('bookings'));
    }

    public function create()
    {
        $users = User::all();
        $units = unit::where('booked', 0)->get();
        $trips = Trip::all();
        return view('dashboard.booking.create', compact('users', 'units', 'trips' ));
    }


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
        if (App::getLocale() == 'ar'){
            if (empty($request->unit_id) && empty($request->trip_id)) {
                return back()->with(['message' => 'رجاء اختر وحدة او رحلة للحجز']);
            }
        }else{
            if (empty($request->unit_id) && empty($request->trip_id)) {
                return back()->with(['message' => 'Please select a unit of trip']);
            }
        }
        if($request->unit_id){
            $units = unit::findOrFail($request->unit_id);
            try {
                Booking::create([
                    'check_in' => $request->check_in,
                    'check_out' => $request->check_out,
                    // 'price' => $request->price,
                    'user_id' => $request->user_id,
                    'unit_id' => $request->unit_id,
                ]);
                $units->booked = 1;
                $units->save();
                return redirect()->route('admin.booking.index')->with(['message' => 'Add Success']);
            } catch (Exception $e) {
                Log::info($e->getMessage());
                return redirect()->route('admin.booking.index')->with(['message' => $e->getMessage()]);
            }
        }else{
            try {
                Booking::create([
                    'check_in' => $request->check_in,
                    'check_out' => $request->check_out,
                    // 'price' => $request->price,
                    'user_id' => $request->user_id,
                    'trip_id' => $request->trip_id,
                ]);
                return redirect()->route('admin.booking.index')->with(['message' => 'Add Success']);
            } catch (Exception $e) {
                Log::info($e->getMessage());
                return redirect()->route('admin.booking.index')->with(['message' => $e->getMessage()]);
            }
        }
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $trips = Trip::all();
        $users = User::all();
        $currentUnitId = $booking->unit_id;
        $units = unit::whereDoesntHave('bookings', function ($query) use ($currentUnitId) {
            $query->where('unit_id', '!=', $currentUnitId);
        })->orWhere('id', $currentUnitId)->get();
        return view('dashboard.booking.edit', compact('booking', 'users', 'units', 'trips'));
    }

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
        if($request->unit_id){
            $units = unit::findOrFail($request->unit_id);
            try {
                $booking->update([
                    'check_in' => $request->check_in,
                    'check_out' => $request->check_out,
                    // 'price' => $request->price,
                    'user_id' => $request->user_id,
                    'unit_id' => $request->unit_id,
                    
                ]);
                $units->booked = 1;
                $units->save();
                return redirect()->route('admin.booking.index')->with(['message' => 'edit Success']);
            } catch (Exception $e) {
                Log::info($e->getMessage());
                return redirect()->route('admin.booking.index')->with(['message' => $e->getMessage()]);
            }
        }else{
            try {
                $booking->update([
                    'check_in' => $request->check_in,
                    'check_out' => $request->check_out,
                    // 'price' => $request->price,
                    'user_id' => $request->user_id,
                    'trip_id' => $request->trip_id,
                    
                ]);
                return redirect()->route('admin.booking.index')->with(['message' => 'edit Success']);
            } catch (Exception $e) {
                Log::info($e->getMessage());
                return redirect()->route('admin.booking.index')->with(['message' => $e->getMessage()]);
            }
        }
    }

    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            if($booking->unit != null){
                $unit = $booking->unit;
                $booking->delete();
                $unit->booked = 0;
                $unit->save();
                return redirect()->back();
            }
            $booking->delete();
            return redirect()->back();
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return redirect()->route('admin.booking.index')->with(['message' => $e->getMessage()]);
        }
    }
}
