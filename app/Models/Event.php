<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';

    protected $fillable = [
        'title', 
        'image',
        'date_start',
        'date_end',
        'time_start',
        'time_end',
        'id_city',
        'payment_method',
        'chat_hash',
        'description',
        'asistence_confirm',
        'share_confirm',
        'admins',
        'id_user'
    ];

    protected $hidden = [];
}


