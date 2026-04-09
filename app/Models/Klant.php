<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klant extends Model
{
    use HasFactory;

    protected $table = 'klant';

    public const CREATED_AT = 'datum_aangemaakt';
    public const UPDATED_AT = 'datum_gewijzigd';

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
}
