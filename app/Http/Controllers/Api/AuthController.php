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
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'user_type' => 'required|string|in:company,owner,visitor',
            'id' => 'required_if:user_type,company|exists:users,id',
        ]);

        // Authenticate the user
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(['error' => 'Credentials do not match'], 401);
        }

        // Find the user based on email and user type
        $user = User::where('email', $request->email)
                    ->where('user_type', $request->user_type)
                    ->first();

        if (!$user) {
            return response()->json(['error' => 'No user found with the specified user type'], 404);
        }

        // Check company id match if user type is company
        if ($request->user_type === 'company' && $request->id != $user->id) {
            return response()->json(['error' => 'The provided ID does not match the user'], 403);
        }

        // Retrieve activity data based on company type
        $activity_id = null;
        if ($user->user_type === 'company') {
            switch ($user->company_activity) {
                case 'restaurant':
                    $activity_id = $user->restaurants()->first()->id ?? null;
                    break;
                case 'cafe':
                    $activity_id = $user->cafes()->first()->id ?? null;
                    break;
                case 'cinema':
                    $activity_id = $user->cinemas()->first()->id ?? null;
                    break;
                case 'tourism':
                    $activity_id = $user->tourisms()->first()->id ?? null;
                    break;
                case 'hotel':
                    $activity_id = $user->hotels()->first()->id ?? null;
                    break;
                case 'market':
                    $activity_id = $user->markets()->first()->id ?? null;
                    break;
                case 'other':
                    $activity_id = $user->others()->first()->id ?? null;
                    break;
            }
        }

        // Generate an API token
        $token = $user->createToken('Api Token of -' . $user->name)->plainTextToken;

        // Prepare user data
        $userData = [
            'name' => $user->name,
            'image' => $user->image,
            'email' => $user->email,
            'user_type' => $user->user_type,
            'company_activity' => $user->user_type === 'company' ? $user->company_activity : null,
            'commercial_record' => $user->user_type === 'company' ? $user->commercial_record : null,
            'tax_card' => $user->user_type === 'company' ? $user->tax_card : null,
            'updated_at' => $user->updated_at->toIso8601String(),
            'created_at' => $user->created_at->toIso8601String(),
            'id' => $user->id,
            'activity_id' => $activity_id
        ];

        return response()->json([
            'status' => 'User Login Success',
            'token' => $token,
            'user' => $userData,
            'qr_code_path' => $user->code
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
            'company_activity' => [
                'required_if:user_type,company',
                'nullable',
                'string',
                'in:restaurant,cafe,cinema,tourism,hotel,market,other'
            ],
        ]);

        try {
            // Handle the image upload
            $imagePath = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : null;

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
            $qrCode = QrCode::format('png')->size(300)->generate((string)$user->id);
            $qrCodePath = 'profile/user_' . uniqid() . '.png';
            Storage::disk('public')->put($qrCodePath, $qrCode);
            $user->update(['code' => $qrCodePath]);

            // Prepare response data
            $responseData = [
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
                    'company_activity' => $user->user_type === 'company' ? $user->company_activity : null,
                    'commercial_record' => $user->user_type === 'company' ? $user->commercial_record : null,
                    'tax_card' => $user->user_type === 'company' ? $user->tax_card : null,
                    'qr_code_path' => $user->code,
                    'created_at' => $user->created_at->toIso8601String(),
                    'updated_at' => $user->updated_at->toIso8601String(),
                ]
            ];

            return response()->json($responseData, 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'Registration Failed',
                'message' => $e->getMessage(),
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
