<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToFacebook($facebook)
    {
        return Socialite::driver($facebook)->stateless()->redirect();
    }

    public function handleFacebookCallback($facebook)
    {
        try {
            $socialUser = Socialite::driver($facebook)->stateless()->user();
            $user = User::where('email', $socialUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(str::random(24)),
                    'social_type' => $facebook,
                    'social_id' => $socialUser->getId(),
                ]);
            } else {
                $user->update([
                    'social_type' => $facebook,
                    'social_id' => $socialUser->getId(),
                ]);
            }
            Auth::login($user);
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unauthorized',
                'error' => $e->getMessage(),
            ], 401);
        }
    }


    public function redirectToTwitter($twitter)
    {
        return Socialite::driver($twitter)->stateless()->redirect();
    }

    public function handleTwitterCallback($twitter)
    {
        try {
            $socialUser = Socialite::driver($twitter)->stateless()->user();
            $user = User::where('email', $socialUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(str::random(24)),
                    'social_type' => $twitter,
                    'social_id' => $socialUser->getId(),
                ]);
            } else {
                $user->update([
                    'social_type' => $twitter,
                    'social_id' => $socialUser->getId(),
                ]);
            }
            Auth::login($user);
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unauthorized',
                'error' => $e->getMessage(),
            ], 401);
        }
    }
}
