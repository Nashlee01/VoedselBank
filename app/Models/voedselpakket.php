<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voedselpakket extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Tabelnaam
    |--------------------------------------------------------------------------
    */
    protected $table = 'voedselpakket';

    /*
    |--------------------------------------------------------------------------
    | Mass assignment
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'klant_id',
        'datum_uitgifte',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Timestamps uitzetten
    |--------------------------------------------------------------------------
    | Laravel probeert standaard created_at en updated_at op te slaan.
    | Omdat jouw tabel deze kolommen niet correct gebruikt, zetten we dat uit.
    */
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Relatie naar klant
    |--------------------------------------------------------------------------
    */
    public function klant()
    {
        return $this->belongsTo(Klant::class, 'klant_id', 'klant_id');
    }
}