<?php

namespace App;
use Illuminate\Database\Eloquent\Model;



class Sections extends Model
{

    protected $fillable = ['name','parent','name','noarticles','author'];

    public function articles()
    {
        return $this->belongsTo('App\Articles','sectionid','id');
    }
}
