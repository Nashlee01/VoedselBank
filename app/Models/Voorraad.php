<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voorraad extends Model
{
    protected $table = 'voorraad';

    protected $fillable = [
        'product_id',
        'hoeveelheid',
        'locatie',
        'vervaldatum',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
