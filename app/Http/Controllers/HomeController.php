<?php

namespace App\Http\Controllers;

use Session;
use Auth;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $data['count'] = count($user->unreadNotifications);
        $data['notifications'] = $user->unreadNotifications()->limit(7)->get();

        $drafts = new \App\Http\Helpers\DraftCount;
        Session::put('count', $drafts->numberOf());


        return view('home',$data);
    }
}
