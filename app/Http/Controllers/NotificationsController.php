<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications;
use App\Notifications\AdminNotification;
use App\Http\Helpers\FCMNotification;
use Auth;
use Illuminate\Support\Facades\Notification;
use App\User;


class NotificationsController extends Controller
{


    public function index($id = null)
    {
        $user = Auth::user();

        if ($id !== null)
        {

            $data['current_notification'] = Notifications::find($id);
            $data['current_notification']->read_at = now();
            $data['current_notification']->save();

            $data['current_notification']->data = json_decode($data['current_notification']->data, true);


        }
        $data['count'] = count($user->Notifications);

        $data['notifications'] =  $user->Notifications()->paginate(10);

        return view('notifications.index',$data);

    }

    public function checkbox(Request $request)
    {

        $id = $request->id;
        $property = $request->property;


        $notification = auth()->user()->Notifications()->find($id);


        if($property == 'true')
        {

            $notification->markAsRead();

        } else

        {

            $notification->markAsUnRead();

        }

        $notification->save();

        return ['message' => 'success'];

    }

    public function show(Request $request)
    {
        $id = $request->id;
        $notification = auth()->user()->Notifications()->find($id);

        return $notification->toJson();

    }

    public function delete(Request $request)
    {

        $id = $request->id;
        $notification = auth()->user()->Notifications()->find($id)->delete();

        return ['message' => 'success'];

    }

    public function create()
    {


        $data['users'] = User::where('status','active')->get();

        return view('notifications.create',$data);




    }

    public function send(Request $request)
    {

        if ($request->users == 0)
        {
            $users = User::where('status','active')->get();
            $fcmUser = 0;
        }
        else
        {
            $users = User::find($request->users);
            $fcmUser = $users->id;
        }



        $data['commentor'] = "KB";
        $data['comment'] = $request->message;


        $channel = array();
        if ($request->email == "on")
        {
            array_push($channel,'mail');
        }
        if ($request->notification == "on")
        {
            array_push($channel,'database');

            $fcmMessage = new FCMNotification;
            $fcmMessage->send($data,$fcmUser);
        }


        Notification::send($users, new AdminNotification($data,$channel));


        return redirect()->back()->withSuccess('Notification Sent');

    }



}
