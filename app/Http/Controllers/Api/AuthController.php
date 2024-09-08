<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AuthController extends Controller
{
    
public function login_user(Request $request)
{
    $request->validate([
        'email' => 'required',
        'password' => 'required',
        'user_type' => 'required|string|in:company,owner,visitor',
    ]);

    // Attempt to authenticate the user
    if (!Auth::attempt($request->only(['email', 'password']))) {
        return response()->json([
            'error' => 'Credentials Do Not Match'
        ], 401);
    }

    // Find the user with the specific email and user type
    $user = User::where('email', $request->email)
                ->where('user_type', $request->user_type)
                ->first();
    if (!$user) {
        return response()->json([
            'error' => 'No user found with the specified user type'
        ], 404);
    }

    // Generate the token for the user
    $token = $user->createToken('Api Token of -' . $request->name)->plainTextToken;

    // Return the login response with user details, image path, and QR code path
    return response()->json([
        'status' => 'User Login Success',
        'token' => $token,
        'user' => [
            'name' => $user->name,
            'image' => $user->image, // Return the relative path to the image
            'email' => $user->email,
            'user_type' => $user->user_type,
            'updated_at' => $user->updated_at->toIso8601String(),
            'created_at' => $user->created_at->toIso8601String(),
            'id' => $user->id,
        ],
        'qr_code_path' => $user->code // Return the relative path to the QR code image stored in the 'code' column
    ], 200);
}



public function register_user(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed',
        'user_type' => 'required|string|in:company,owner,visitor',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for the image
    ]);

    try {
        // Handle the image upload if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Save image to storage/app/public/images
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'image' => $imagePath, // Store only the relative path
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
        ]);

        // Define QR code data (e.g., user ID or email)
        $qrData = $user->id; // Make sure this is a string or a properly formatted value
        $qrDataString = (string)$qrData; // Convert to string if necessary

        // Generate QR code
        $qrCode = QrCode::format('png')->size(300)->generate($qrDataString);

        // Generate a file name for the QR code
        $qrCodeFileName = 'user_' . uniqid() . '.png';

        // Define the path to store the QR code image
        $qrCodePath = 'profile/' . $qrCodeFileName;

        // Store the QR code image in the public storage path
        Storage::disk('public')->put($qrCodePath, $qrCode);

        // Save the QR code path to the 'code' column in the user record
        $user->update(['code' => $qrCodePath]);

        // Return the API response
        return response()->json([
            'status' => 'User Registered',
            'token' => $user->createToken('Api Token of -' . $request->name)->plainTextToken,
            'user' => [
                'name' => $user->name,
                'image' => $user->image, // Return the relative path
                'email' => $user->email,
                'user_type' => $user->user_type,
                'updated_at' => $user->updated_at->toIso8601String(),
                'created_at' => $user->created_at->toIso8601String(),
                'id' => $user->id,
            ],
            'qr_code_path' => $qrCodePath // Return only the relative path of the QR code image
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'User Register Failed',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function logout_user(){
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'User Logout Successfully and Your Token has been deleted'
        ], 200);
    }

 

}
