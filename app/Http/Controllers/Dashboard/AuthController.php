<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AuthRequest;
use App\Http\Requests\Dashboard\ResetRequest;
use App\Mail\ResetPassword;
use App\Repositories\Contract\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function showLoginForm()
    {
        return \view('dashboard.auth.login');
    }

    public function login(AuthRequest $request)
    {
        //attempt to log admin
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'isVerified' => 1], $request->get('remember'))) {
            return \redirect()->intended(route('admin.home'))->with('success', __('models.login_success'));
        }

        return redirect()->back()->withInput($request->only('email','remember'))->with('error', __('models.login_error'));

    }

    public function logout(Request $request)
    {   
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function reset()
    {
        return view('dashboard.auth.reset');
    }

    public function sendLink(Request $request)
    {
        $user = $this->userRepository->getWhere(['email' => $request->email])->first();

        if ($user) {

            $code = \rand(1111, 9999);

            $user->update(['code' => $code]);

            $data = [
                'link' => route('admin.changePassword' , $code)
            ];

            Mail::to($user->email)->send(new ResetPassword($data));

            return redirect()->back()->with('success' , __('models.link_sent'));

        } else
        {

            return redirect()->back()->with('error' , __('models.email_not_found'));

        }

    }

    public function changePassword($code)
    {

        $user = $this->userRepository->getWhere(['code' => $code])->first();

        if ($user) {
            return view('dashboard.auth.changePassword' , \compact('code'));
        } else {
            return \view('dashboard.auth.error');
        }

    }

    public function updatePassword(ResetRequest $request)
    {

        $user = $this->userRepository->getWhere(['code' => $request->code])->first();

        if ($user->isVerified == 1) {

            $newPassword = $user->update(['password' => bcrypt($request->password)]);

        }

        if ($newPassword) {

            Auth::login($user);

            $user->update(['code' => null]);

            return \redirect(\route('admin.home'))->with('success', __('models.pass_changed'));

        } else {
            return redirect()->back()->with('error', __('models.pass_error'));
        }
    }

}
