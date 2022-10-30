<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Helpers\FCMNotification;
use App\Http\Middleware\TrustProxies;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Hash;
use App\Tokens;

class ProfileController extends Controller
{
    public function index()
    {
/*
        //$firebaseToken = User::find(1)->tokens->pluck('token');
        $firebaseToken[] = 'fNBnQk7DYNG_GuVJKfbbOz:APA91bFB-GHDGZp7qMSFXObuUTfNL2JXbKSJcaRUCfRmr_efAoke6q9xMcaKMrddEAJ68tbVQ8-H_aX2VCuVB1IAzvGbz4fPsBAElfK8Vue2_eUFJWfSXtiO7yyISYHnGYc6U6FX92wq';
        $SERVER_API_KEY = 'AAAAGMZCCjQ:APA91bH1DEZPxk8GDaYCUdjS5DI8AlTzBXQRSMB8uAG5hJU0r-kG-W9iyZSnhYGwngePQGp6SwzwHBLEG-F-6FOMZu10daO1tejhcYMf6K7tbAqF_oOf2o3loSNSF3nyqmXMGURQ-tAB';


        $data = [
            "registration_ids" => $firebaseToken,
            "title" => 'A message from KB',
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);


        $response = curl_exec($ch);
        dd($response);
        die();
        $a = json_decode($response);
        dd($a->results);

        if($a->success)
        {
            echo "token is ok";
        }
        else
        {
            echo "token is not ok";
         }


*/


        $data['user'] = auth()->user();

        return view('profiles.index',$data);

    }

    public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'image|mimes:jpg,jpeg,png|max:2048'
            ]);



        $user = User::find(auth()->user()->id);



        if($request->hasfile('avatar'))
            {
                $fileName = rand(0,1000) . time() . '~' . $request->file('avatar')->getClientOriginalName();

                $request->file('avatar')->storeAs('/avatars/', $fileName);

                $user->avatar = $fileName;


            }

        if ($request->pwcheck == "on")
        {
            $user->password = Hash::make($request->pw1);
        }


        $user->save();
        return redirect(url('/home'))->withSuccess('Details updated');
    }


    public function saveToken(Request $request)
    {

        $agent = new Agent();

        $token = new Tokens;

        $token->user_id = auth()->user()->id;
        $token->token = $request->token;
        $token->browser = $agent->browser();
        $token->browser_version = $agent->version($agent->browser());

        $token->platform = $agent->platform();
        $token->platform_version = $agent->version($agent->platform());

        $token->save();
        $user = User::find(auth()->user()->id);
        $user->push_notifications = 1;
        $user->save();

        return response()->json(['saved', 200]);
    }

    public function deleteToken()
    {

        $user = User::find(auth()->user()->id);
        $user->push_notifications = 0;
        $user->save();
        Tokens::findOrFail($user->id)->delete();
        return response()->json(['token removed',200]);
    }

}
