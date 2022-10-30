<?php
namespace App\Http\Helpers;
use App\Settings;
use App\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewArticle;
use App\Http\Helpers\FCMNotification;



class NewArticleNotifications
{
    private function email_all()
    {
        return Settings::find(1)->email_all;
    }

    private function notify_all()
    {
        return Settings::find(1)->notifications;

    }

    public function new_article_notification($data)
    {
        $channel = array();
        if ($this->email_all())
            {array_push($channel,'mail');}
        if ($this->notify_all())
            {array_push($channel,'database');}

        if(count($channel) > 0)
        {
            $users = User::where('status','active')->get();
            //$users = User::find(22);
            Notification::send($users, new NewArticle($data,$channel));
        }

        if ($this->notify_all())
        {

            $users = 0;
            $fcmMessage = new FCMNotification;

            $message = "A new article has been added by." .chr(10);
            $message .= "'". $data['user'] . "'" . chr(10);
            $message .= "'" . $data['title'] . "' has been added to section." . chr(10);
            $message .= $data['section'];
            $data['comment'] = $message;
            $fcmMessage->send($data,$users);


        }

        return;
    }

}
