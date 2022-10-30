<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $fillable = [
        'userid', 'last_login', 'ip'
    ];

    public $timestamps = true;

    protected $table = "user_login";

    public function user()
    {
        return $this->belongsTO('App\User');
    }


}
