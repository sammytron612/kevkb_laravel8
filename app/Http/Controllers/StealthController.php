<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;

class StealthController extends Controller
{


    public function change(Request $request)
    {

        if($request->status == "true"){$v = 1;} else {$v = 0;}

        $settings = Settings::find(1);
        $settings->stealth = $v;
        $settings->save();
        return $v;
    }
}
