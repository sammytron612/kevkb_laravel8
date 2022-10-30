<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{

    protected $fillable = ['title','slug','body','author','author_name','sectionid','tags','attachments','views','rating','status','approved','published'];

    public function sections()
    {
        return $this->hasOne('App\Sections','id','sectionid');
    }

    public function users()
    {
        return $this->belongsTO('App\User','author','id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comments','articleid','id');
    }

    public function body()
    {
        return $this->hasOne('App\ArticleBody');
    }

    public function searchableAs()
    {
        return 'kevkb_index';
    }

}
