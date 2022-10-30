<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Snows extends Model
{
    use Searchable;

    protected $fillable = ['title','tags','description','group'];
    public $timestamps = false;

    public function searchableAs()
    {
        return 'snow_index';
    }

}
