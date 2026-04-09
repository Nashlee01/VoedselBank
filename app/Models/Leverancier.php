<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    protected $table = 'leverancier';

    protected $fillable = [
        'naam',
        'email',
        'telefoon',
        'adres',
        'status',
    ];
}
