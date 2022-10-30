<?php
namespace App\Http\Helpers;
use App\User;
use App\Tokens;

class FCMNotification
{
    public function send($data1,$users)
    {

        if ($users == 0)
        {
            $firebaseToken = Tokens::pluck('token')->all();
        }
        else
        {
            $firebaseToken = User::find($users)->tokens->pluck('token');
        }



        $SERVER_API_KEY = 'AAAAGMZCCjQ:APA91bH1DEZPxk8GDaYCUdjS5DI8AlTzBXQRSMB8uAG5hJU0r-kG-W9iyZSnhYGwngePQGp6SwzwHBLEG-F-6FOMZu10daO1tejhcYMf6K7tbAqF_oOf2o3loSNSF3nyqmXMGURQ-tAB';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => 'A message from KB',
                "body" => $data1['comment'],
            ]
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

        try
        {
        $response = curl_exec($ch);
        //dd($response);
        }
        catch (\Exception $e)
        {}


        return;
    }

}
