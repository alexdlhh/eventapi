<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statics_texts extends Model
{
    protected $table = 'statics_texts';

    protected $fillable = [
        'title', 
        'body',
    ];

    protected $hidden = [];
}
