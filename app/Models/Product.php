<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'naam',
        'categorie',
        'ean',
        'aantal',
    ];

    public function voorraad(): HasOne
    {
        return $this->hasOne(Voorraad::class, 'product_id');
    }
}
