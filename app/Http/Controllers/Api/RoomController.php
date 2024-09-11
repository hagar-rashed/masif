<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Models\RoomBooking; // Assuming you have a RoomBooking model
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    public function index(Request $request) {
        try {
            // Optional filters
            $hotelId = $request->query('hotel_id');
            $availabilityFrom = $request->query('from_date');
            $availabilityTo = $request->query('to_date');

            // Build query based on filters
            $query = Room::query();

            if ($hotelId) {
                $query->where('hotel_id', $hotelId);
            }

            if ($availabilityFrom && $availabilityTo) {
                $query->where(function ($query) use ($availabilityFrom, $availabilityTo) {
                    $query->whereDate('from_date', '<=', $availabilityTo)
                          ->whereDate('to_date', '>=', $availabilityFrom);
                });
            }

            // Fetch rooms with optional filters applied
            $rooms = $query->get();

            return response()->json([
                'message' => 'Rooms retrieved successfully',
                'data' => $rooms->map(function ($room) {
                    return [
                        'room_type' => $room->room_type,
                        'number_of_rooms' => $room->number_of_rooms,
                        'price_per_night' => $room->price_per_night,
                        'number_of_nights' => $room->number_of_nights,
                        'original_price' => $room->original_price,
                        'discount' => $room->discount,
                        'total_price' => $room->total_price,
                        'payment_method' => $room->payment_method,
                        'availability' => [
                            'from_date' => $room->from_date->toDateString(),
                            'to_date' => $room->to_date->toDateString(),
                        ],
                        'description' => $room->description,
                        'facilities' => $room->facilities,
                    ];
                }),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to retrieve rooms',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id) {
        try {
            $room = Room::find($id);

            if (!$room) {
                return response()->json(['error' => 'Room not found'], 404);
            }

            return response()->json([
                'message' => 'Room retrieved successfully',
                'data' => [
                    'room_type' => $room->room_type,
                    'number_of_rooms' => $room->number_of_rooms,
                    'price_per_night' => $room->price_per_night,
                    'number_of_nights' => $room->number_of_nights,
                    'original_price' => $room->original_price,
                    'discount' => $room->discount,
                    'total_price' => $room->total_price,
                    'payment_method' => $room->payment_method,
                    'availability' => [
                        'from_date' => $room->from_date->toDateString(),
                        'to_date' => $room->to_date->toDateString(),
                    ],
                    'description' => $room->description,
                    'facilities' => $room->facilities,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while retrieving the room',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'hotel_id' => 'required|integer|exists:hotels,id',
                'room_type' => 'string|required',
                'from_date' => 'required|date',
                'to_date' => 'required|date',
                'number_of_rooms' => 'integer|required',
                'price_per_night' => 'integer|required',
                'number_of_nights' => 'integer|required',
                'discount' => 'integer|nullable',
                'payment_method' => 'string|required',
                'description' => 'string|nullable',
                'facilities' => 'array|nullable',
                'facilities.*' => 'string'
            ], $this->validationMessages());

            // Calculate original_price
            $validated['original_price'] = $validated['price_per_night'] * $validated['number_of_nights'];

            // Calculate total_price considering discount (if provided)
            $discount = $validated['discount'] ?? 0; // Default discount to 0 if not provided
            $validated['total_price'] = $validated['original_price'] - ($discount / 100) * $validated['original_price'];

            $room = Room::create([
                'hotel_id' => $validated['hotel_id'],
                'room_type' => $validated['room_type'],
                'from_date' => $validated['from_date'],
                'to_date' => $validated['to_date'],
                'number_of_rooms' => $validated['number_of_rooms'],
                'price_per_night' => $validated['price_per_night'],
                'number_of_nights' => $validated['number_of_nights'],
                'original_price' => $validated['original_price'],
                'discount' => $validated['discount'],
                'total_price' => $validated['total_price'],
                'payment_method' => $validated['payment_method'],
                'description' => $validated['description'],
                'facilities' => $validated['facilities'],
            ]);

            return response()->json([
                'message' => 'Room created successfully',
                'data' => $room,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while creating the room',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $room = Room::find($id);

            if (!$room) {
                return response()->json(['error' => 'Room not found'], 404);
            }

            $validated = $request->validate([
                'room_type' => 'string|nullable',
                'from_date' => 'nullable|date',
                'to_date' => 'nullable|date',
                'number_of_rooms' => 'integer|nullable',
                'price_per_night' => 'integer|nullable',
                'number_of_nights' => 'integer|nullable',
                'discount' => 'integer|nullable',
                'payment_method' => 'string|nullable',
                'description' => 'string|nullable',
                'facilities' => 'array|nullable',
                'facilities.*' => 'string'
            ], $this->validationMessages());

            // Recalculate original_price if price_per_night and number_of_nights are provided
            if (isset($validated['price_per_night']) && isset($validated['number_of_nights'])) {
                $validated['original_price'] = $validated['price_per_night'] * $validated['number_of_nights'];
            }

            // Recalculate total_price considering the discount
            if (isset($validated['original_price'])) {
                $discount = $validated['discount'] ?? 0;
                $validated['total_price'] = $validated['original_price'] - ($discount / 100) * $validated['original_price'];
            }

            $room->update($validated);

            return response()->json([
                'message' => 'Room updated successfully',
                'data' => $room,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating the room',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id) {
        try {
            $room = Room::find($id);

            if (!$room) {
                return response()->json(['error' => 'Room not found'], 404);
            }

            $room->delete();

            return response()->json([
                'message' => 'Room deleted successfully',
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the room',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function validationMessages() {
        return [
            'hotel_id.required' => 'The hotel ID is required.',
            'hotel_id.exists' => 'The hotel must exist.',
            'room_type.required' => 'The room type is required.',
            'number_of_rooms.required' => 'The number of rooms is required.',
            'price_per_night.required' => 'The price per night is required.',
            'total_price.required' => 'The total price is required.',
            'payment_method.required' => 'The payment method is required.',
        ];
    }
}
