<?php

namespace App\Http\Controllers;
use App\Mail\TestEmail;
use App\Mail\EmailArticle;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\URL;
use App\User;

class EmailController extends Controller
{

    public function email_invite(Request $request)
    {

        $request->validate([
            'email' => 'required|email|unique:users',
        ]);

        $url = URL::temporarySignedRoute('registeruser', now()->addHours(24), ['user' => $request->email]);

        $data = ['message' =>  $url];

        Mail::to($request->email)->send(new TestEmail($data));

        return redirect(route('admin.invites'))->withSuccess('Email sent');

    }

    public function email_article(Request $request)
    {


        $url = URL::temporarySignedRoute('email_article', now()->addMinutes(60), ['id' => $request->id]);
        $user = auth()->user();
        $data = [
            'url' =>  $url,
            'title' => $request->title,
            'user' => $user->name

        ];


        Mail::to($request->email)->send(new EmailArticle($data));

        return back()->withSuccess('Email sent');

    }


}
