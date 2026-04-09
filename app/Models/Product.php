<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'naam',
        'categorie',
        'ean',
        'aantal',
    ];
}
