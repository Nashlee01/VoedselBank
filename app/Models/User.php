<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * Alleen deze velden mogen ingevuld worden.
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * Verberg wachtwoord bij serialisatie.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Zet timestamps uit, omdat jouw users tabel geen created_at / updated_at gebruikt.
     */
    public $timestamps = false;
}