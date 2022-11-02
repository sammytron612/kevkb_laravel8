<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'email_all', 'approve_articles', 'allow_delete','notifications','fulltext', 'bts'
    ];

    public $timestamps = false;
}
