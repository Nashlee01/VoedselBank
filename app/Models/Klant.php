<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klant extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Tabel en primary key
    |--------------------------------------------------------------------------
    */
    protected $table = 'klant';
    protected $primaryKey = 'klant_id';

    public const CREATED_AT = 'datum_aangemaakt';
    public const UPDATED_AT = 'datum_gewijzigd';

    /*
    |--------------------------------------------------------------------------
    | Velden die mass assignable zijn
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'gezinsnaam',
        'straat',
        'huisnummer',
        'toevoeging',
        'postcode',
        'plaats',
        'telefoonnummer',
        'email',
        'aantal_volwassenen',
        'aantal_kinderen',
        'aantal_babys',
        'geboortedata_volwassenen',
        'geboortedata_kinderen',
        'geboortedata_babys',
        'is_actief',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    | JSON uit de database wordt automatisch omgezet naar arrays.
    */
    protected $casts = [
        'geboortedata_volwassenen' => 'array',
        'geboortedata_kinderen' => 'array',
        'geboortedata_babys' => 'array',
        'is_actief' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relatie met voedselpakketten
    |--------------------------------------------------------------------------
    */
    public function voedselpakketten()
    {
        return $this->hasMany(Voedselpakket::class, 'klant_id', 'klant_id');
    }
}