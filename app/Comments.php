<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = ['comment','userid','rating','articleid','name'];

    public function users()
    {
        return $this->belongsTO('App\User','userid','id');
    }

    public function articles()
    {
        return $this->belongsTO('App\Articles','articleid','id');
    }

}
