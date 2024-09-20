<?php

    namespace App\Http\Controllers\Api;
    
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Room;
    use App\Models\RoomBooking;
    use App\Models\RoomAvailability;
    use App\Models\RoomOffer;
    use Illuminate\Support\Facades\Validator;
    use SimpleSoftwareIO\QrCode\Facades\QrCode; 
    use Illuminate\Support\Facades\Storage; 
    use Carbon\Carbon;
    
    class RoomBookingController extends Controller
    {
        public function store(Request $request)
        {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'room_id' => 'required|exists:rooms,id',
                'from_date' => 'required|date',
                'to_date' => 'required|date|after_or_equal:from_date',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
        
            // Check if the room is available for the requested dates
            $room = Room::findOrFail($request->room_id);
            $availability = RoomAvailability::where('room_id', $room->id)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_date', [$request->from_date, $request->to_date])
                          ->orWhereBetween('end_date', [$request->from_date, $request->to_date])
                          ->orWhere(function ($query) use ($request) {
                              $query->where('start_date', '<=', $request->from_date)
                                    ->where('end_date', '>=', $request->to_date);
                          });
                })
                ->get();
        
            if ($availability->isEmpty()) {
                return response()->json(['message' => 'Room is not available for the selected dates'], 400);
            }
        
            // Update availability for the remaining nights
            foreach ($availability as $available) {
                if ($available->start_date < $request->from_date && $available->end_date > $request->to_date) {
                    // Split availability into two separate periods
                    RoomAvailability::create([
                        'room_id' => $room->id,
                        'start_date' => Carbon::parse($request->to_date)->addDay(),
                        'end_date' => $available->end_date,
                    ]);
                    $available->end_date = Carbon::parse($request->from_date)->subDay();
                    $available->save();
                } elseif ($available->start_date < $request->from_date) {
                    // Adjust end date if booking starts after the availability period begins
                    $available->end_date = Carbon::parse($request->from_date)->subDay();
                    $available->save();
                } elseif ($available->end_date > $request->to_date) {
                    // Adjust start date if booking ends before the availability period ends
                    $available->start_date = Carbon::parse($request->to_date)->addDay();
                    $available->save();
                } else {
                    // If the entire period is booked, delete this availability
                    $available->delete();
                }
            }
        
            // Calculate number of nights
            $fromDate = Carbon::parse($request->from_date);
            $toDate = Carbon::parse($request->to_date);
            $numberOfNights = $fromDate->diffInDays($toDate) + 1;
        
            // Calculate total price
            $totalPrice = $numberOfNights * $room->night_price;
        
            // Check for active offers
            $activeOffers = RoomOffer::where('room_id', $room->id)
                ->where('start_date', '<=', $fromDate)
                ->where('end_date', '>=', $toDate)
                ->get();
        
            $discount = 0;
            foreach ($activeOffers as $offer) {
                $discount = max($discount, $offer->discount);
            }
        
            // Apply discount if any
            $totalPrice = $totalPrice - ($totalPrice * ($discount / 100));
        
            // Store the booking
            $booking = RoomBooking::create([
                'room_id' => $room->id,
                'user_id' => auth()->id(),
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'number_of_nights' => $numberOfNights,
                'original_price' => $room->night_price,
                'discount' => $discount,
                'total_price' => $totalPrice,
            ]);
        
            // Generate QR code with booking details
            $qrData = 'Booking ID: ' . $booking->id . ', Room: ' . $room->name . ', Dates: ' . $request->from_date . ' to ' . $request->to_date;
            $qrCode = QrCode::format('png')->size(300)->generate($qrData);
        
            // Store the QR code image
            $qrCodePath = 'qrcodes/booking-' . $booking->id . '.png';
            Storage::disk('public')->put($qrCodePath, $qrCode);
        
            // Save the QR code path
            $booking->qr_code_path = $qrCodePath;
            $booking->save();
        
            return response()->json([
                'message' => 'Room booked successfully',
                'booking' => $booking,
                'qr_code_url' => asset('storage/' . $qrCodePath)
            ], 201);
        }
    
        
    
    

    public function show($id)
    {
        $booking = RoomBooking::with('room', 'user')->findOrFail($id);
        return response()->json($booking, 200);
    }

    public function destroy($id)
    {
        $booking = RoomBooking::findOrFail($id);

        $this->restoreAvailability($booking);

        $booking->delete();

        return response()->json(['message' => 'Booking cancelled successfully'], 200);
    }

    private function restoreAvailability($booking)
    {
        $existingAvailability = RoomAvailability::where('room_id', $booking->room_id)
            ->orderBy('start_date')
            ->get();

        $merged = false;

        foreach ($existingAvailability as $available) {
            // Check if we can merge with existing availability (before or after the booking)
            if ($available->end_date == Carbon::parse($booking->from_date)->subDay()) {
                $available->end_date = $booking->to_date;
                $available->save();
                $merged = true;
            } elseif ($available->start_date == Carbon::parse($booking->to_date)->addDay()) {
                $available->start_date = $booking->from_date;
                $available->save();
                $merged = true;
            }
        }

        // If not merged, create a new availability entry
        if (!$merged) {
            RoomAvailability::create([
                'room_id' => $booking->room_id,
                'start_date' => $booking->from_date,
                'end_date' => $booking->to_date,
            ]);
        }
    }
}
