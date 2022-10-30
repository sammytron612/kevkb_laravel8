<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Settings;

class SettingsController extends Controller
{

    private function TorF($bool)
    {

        if ($bool) {return 0;} else {return 1;}
    }

    public function getAll()
    {

        $data = Settings::find(1)->get();
        return response()->json($data);
    }

    public function index()
    {

        return view('settings.index');

    }

    public function update(Request $request)
    {
        $settings = Settings::find(1);


        if ($request->has('bool1'))
        {
            $bool = $this->TorF($request->bool1);

            $settings->email_all = $bool;

        }
        if ($request->has('bool2'))
        {
            $bool = $this->TorF($request->bool2);
            $settings->approve_articles = $bool;

        }
        if ($request->has('bool3'))
        {
            $bool = $this->TorF($request->bool3);
            $settings->allow_delete = $bool;

        }
        if ($request->has('bool4'))
        {
            $bool = $this->TorF($request->bool4);
            $settings->notifications = $bool;

        }
        if ($request->has('bool5'))
        {
            $bool = $this->TorF($request->bool5);
            $settings->fulltext = $bool;

        }

        if($settings->save())
            {response()->json("success") ?? response()->json("failure");}
    }
}
