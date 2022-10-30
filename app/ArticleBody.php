<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleBody extends Model
{
    protected $fillable = ['body'];
    public $timestamps = false;

    public function article()
    {
        return $this->belongsTo('App\Articles');
    }


}
