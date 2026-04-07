<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nome', 'data_nascimento'];
    protected $casts = [
        'data_nascimento' => 'date',
    ];
}
