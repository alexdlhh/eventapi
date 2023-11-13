<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favs extends Model
{
    protected $table = 'favs';

    protected $fillable = [
        'id_user', 
        'id_event',
    ];

    protected $hidden = [];
}
