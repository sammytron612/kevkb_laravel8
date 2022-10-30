<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tokens extends Model
{
    protected $table = 'device_tokens';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id', 'token', 'browser','browser_version','platform', 'platform_version'
    ];

    public function users()
    {
        return $this->belongsTO('App\User');
    }
}
