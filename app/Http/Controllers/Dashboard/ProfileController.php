<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = Auth::user();

        return view('dashboard.profile' , compact('user'));
    }

    public function updateProfile(ProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->except('_token', '_method');

        if ($request->password) {
            $data['password'] = \bcrypt($request->password);
        } else {
            $data['password'] = $user->password;
        }

        $user->update($data);

        return redirect()->back()->with('success', __('models.update_success'));
    }
}
