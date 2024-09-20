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
        'id'=>'required_if:user_type,company',
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
            'company_activity'=>($user->company_activity) ? $user->company_activity : null,
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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'location' => 'nullable|string|max:255',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'commercial_record' => 'nullable|string|max:255',
        'tax_card' => 'nullable|string|max:255',
        // company_activity is required if the user_type is company and must be one of the specified options
        'company_activity' => [
            'required_if:user_type,company',
            'nullable',
            'string',
            'in:restaurant,tourism,hotels,markets,additional'
        ],
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
            'image' => $imagePath,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'commercial_record' => $request->commercial_record ?? null,
            'tax_card' => $request->tax_card ?? null,
            'company_activity' => $request->company_activity ?? null,
        ]);

        // Generate and save QR code
        $qrData = $user->id;
        $qrDataString = (string) $qrData;
        $qrCode = QrCode::format('png')->size(300)->generate($qrDataString);
        $qrCodeFileName = 'user_' . uniqid() . '.png';
        $qrCodePath = 'profile/' . $qrCodeFileName;
        Storage::disk('public')->put($qrCodePath, $qrCode);
        $user->update(['code' => $qrCodePath]);

        // Return all user data in the API response
        return response()->json([
            'status' => 'User Registered',
            'token' => $user->createToken('Api Token of -' . $request->name)->plainTextToken,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_type' => $user->user_type,
                'image' => $user->image,
                'location' => $user->location,
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
                'commercial_record' => $user->commercial_record,
                'tax_card' => $user->tax_card,
                'company_activity' => $user->company_activity,
                'qr_code_path' => $user->code,
                'created_at' => $user->created_at->toIso8601String(),
                'updated_at' => $user->updated_at->toIso8601String(),
            ]
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

 public function getNotifications()
    {
        if (!auth()->check()) {
            return response()->json([
                'error' => 'Unauthenticated'
            ], 401);
        }
    
        $user = auth()->user();
        $notifications = $user->notifications; // Fetch all notifications
    
        // Optionally, you can filter notifications based on type
        $notifications = $notifications->filter(function ($notification) {
            return in_array($notification->type, [
                'App\Notifications\VillageNotification',
                'App\Notifications\OfferNotification',
                'App\Notifications\ChatMessageNotification'
            ]);
        });
    
        return response()->json([
            'notifications' => $notifications
        ]);
    }

}
