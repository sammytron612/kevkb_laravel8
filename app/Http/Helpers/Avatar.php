<?php
namespace App\Http\Helpers;

use Auth;
use Session;


class Avatar
{
    public function avatarInit()
    {

        $user = auth()->user();

        $temp = (explode(" ",$user->name));

        $initials = null;
        foreach($temp as $i)
        {
            $initials .= strtoupper($i[0]);

        }

        return $initials;
    }

    public function avatarColour()
    {
        $rand = (rand(0,4));

        switch ($rand) {
            case 0:
                Session::put('avatarColour', "warning");
              break;
            case 1:
                Session::put('avatarColour', "danger");
              break;
            case 2:
                Session::put('avatarColour', "info");
              break;
            case 3:
                Session::put('avatarColour', "success");
              break;
            case 4:
                Session::put('avatarColour', "secondary");
              break;
        }

    }

}
