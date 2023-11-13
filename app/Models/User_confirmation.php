<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_confirmation extends Model
{
    protected $table = 'user_confirmation';

    protected $fillable = [
        'id_event',
        'id_user'
    ];

    protected $hidden = [];
}