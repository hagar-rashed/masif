<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RestaurantBookingRequest;
use Illuminate\Http\JsonResponse;
use SimpleQRCodeGenerator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

use App\Models\RestaurantBooking;

class RestaurantBookingController extends Controller
{

    public function index()
    {
        // Retrieve all bookings
        $bookings = RestaurantBooking::all();

        // Return the list of bookings as JSON
        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:11',
            'appointment_time' => 'required|date_format:Y-m-d H:i:s',
            'number_of_individuals' => 'required|in:1-3,4-6,6-8',
            'payment_method' => 'required|in:cash_on_restaurant,wallet,credit/debit/ATM',
        ]);

        // Create a new booking
        $booking = RestaurantBooking::create($validatedData);

        // Generate QR code and save path
        // Assuming you have a function to generate and save QR code
        $qrCodePath = $this->generateQRCode($booking);
        $booking->qr_code_path = $qrCodePath;
        $booking->save();

        return response()->json(['booking' => $booking, 'message' => 'Booking created successfully'], 201);
    }

    
    public function show($id)
    {
        // Find the booking by its ID
        $booking = RestaurantBooking::find($id);

        // Check if booking exists
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Return the booking data as JSON
        return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        // Find the booking by its ID
        $booking = RestaurantBooking::find($id);

        // Check if booking exists
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'full_name' => 'sometimes|required|string|max:255',
            'mobile_number' => 'sometimes|required|string|max:11',
            'appointment_time' => 'sometimes|required|date_format:Y-m-d H:i:s',
            'number_of_individuals' => 'sometimes|required|in:1-3,4-6,6-8',
            'payment_method' => 'sometimes|required|in:cash_on_restaurant,wallet,credit/debit/ATM',
        ]);

        // Update the booking with validated data
        $booking->update($validatedData);

        // Optionally, you can regenerate the QR code if any relevant field is updated
        // $booking->qr_code_path = $this->generateQRCode($booking);
        // $booking->save();

        // Return the updated booking as JSON
        return response()->json(['booking' => $booking, 'message' => 'Booking updated successfully'], 200);
    }

    


    private function generateQRCode(RestaurantBooking $booking)
    {
        // Extract relevant booking data to include in the QR code
        $data = [
            'full_name' => $booking->full_name,
            'mobile_number' => $booking->mobile_number,
            'appointment_time' => $booking->appointment_time,
            'number_of_individuals' => $booking->number_of_individuals,
            'payment_method' => $booking->payment_method,
        ];
    
        // Convert data array to a JSON string
        $jsonData = json_encode($data);
    
        // Define the directory path
        $directoryPath = public_path('qr_codes');
    
        // Create the directory if it does not exist
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }
    
        // Generate QR code
        $qrCodeFileName = uniqid() . '.png';
        $qrCodePath = $directoryPath . '/' . $qrCodeFileName;
        
        // Generate and save the QR code image
        QrCode::format('png')->size(300)->generate($jsonData, $qrCodePath);
    
        // Return the URL to the QR code image
        return url('qr_codes/' . $qrCodeFileName);
    }
    


    public function destroy($id)
    {
        // Find the booking by its ID
        $booking = RestaurantBooking::find($id);
    
        // Check if the booking exists
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }
    
        // Delete the associated QR code file if it exists
        if ($booking->qr_code_path) {
            // Construct the full path to the QR code file in the public/qr_codes directory
            $qrCodePath = public_path('qr_codes/' . basename($booking->qr_code_path));
    
            // Check if the file exists before attempting to delete it
            if (file_exists($qrCodePath)) {
                unlink($qrCodePath);
            }
        }
    
        // Delete the booking
        $booking->delete();
    
        // Return a success message
        return response()->json(['message' => 'Booking and associated QR code deleted successfully'], 200);
    }
    
    
}   
   
       