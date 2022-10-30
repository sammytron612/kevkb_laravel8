<?php
namespace App\Http\Helpers;

use App\Notifications\ApprovalNotification;
use App\Notifications\UserApprovalNotification;
use App\User;
use Illuminate\Support\Facades\Notification;
use App\Http\Helpers\FCMNotification;


class ApproveArticle
{
    public function approve_emails($user, $title)
    {

        $data = [
            'title' => $title,
            'comment' => 'Comment',
            'user' => $user->name
        ];


        $admins = User::where('role','admin')
                        ->where('status','active')
                        ->get();
        //$admins = User::find(22);

        Notification::send($admins, new ApprovalNotification($data));
        Notification::send($user, new UserApprovalNotification($data));

        $fcmMessage = new FCMNotification;

        foreach($admins as $admin)
        {
            $message = "Article '" . $data['title'] . "'." . chr(10);
            $message .= "Submitted by '" . $user->name . "'." . chr(10);
            $message .= "Is pending approval.";
            $data['comment'] = $message;
            $fcmMessage->send($data,$admin->id);

        }

        $message = "Your article '" . $data['title'] . "'." . chr(10);
        $message .= "Is pending approval.";
        $data['comment'] = $message;
        $fcmMessage->send($data,$user->id);

        return true;
    }

}
