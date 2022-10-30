<?php
namespace App\Http\Helpers;

use App\Notifications\OTP;
use Auth;
use App\User;
use Illuminate\Support\Facades\Notification;


class OTPNotification
{

    public function otp()
    {
        $data = ['otp' => $rand = rand(100000, 999999)];

        Notification::send(Auth::User(), new OTP($data));
        $user = User::find(Auth::User()->id);
        $user->otp = $rand;
        $user->otp_verified = 0;
        $user->save();

        return;

    }
}

