<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use App\User;
use App\Http\Helpers\OTPNotification;


class OTPController extends Controller
{
    public function index()
    {

        return view('auth.otp');
    }

    public function auth(Request $request)
    {
        $code = $request->otp;

        $user = User::find(Auth::User()->id);

        if ($code == $user->otp)
        {

            $user->otp_verified = 1;
            $user->save();

        }
        else{
            return back()->with('error','Thats not the code we sent!');
        }
        return $request->wantsJson()
                    ? new Response('', 204)
                    : redirect('home');
    }

    public function resendOTP()
    {
        $notify = new OTPNotification;
        $notify->otp();
        return back()->with('error','A new code has been sent! Check your email.');
    }

}
