<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Leverancier;

class LeverancierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Leverancier::create([
            'naam' => 'Supermarkt Plus',
            'email' => 'info@supermarktplus.nl',
            'telefoon' => '020-1234567',
            'adres' => 'Hoofdstraat 1, Amsterdam',
            'status' => 'actief',
        ]);

        Leverancier::create([
            'naam' => 'Groenteboer Jansen',
            'email' => 'contact@jansen.nl',
            'telefoon' => '030-7654321',
            'adres' => 'Marktplein 5, Utrecht',
            'status' => 'actief',
        ]);

        Leverancier::create([
            'naam' => 'Bakkerij van Dijk',
            'email' => 'info@vandijkbakery.com',
            'telefoon' => '040-9876543',
            'adres' => 'Bakkerstraat 10, Rotterdam',
            'status' => 'inactief',
        ]);
    }
}
