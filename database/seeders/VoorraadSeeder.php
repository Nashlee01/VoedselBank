<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoorraadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('voorraad')->delete();
        DB::table('products')->delete();

        $now = now();

        $producten = [
            [
                'naam' => 'Pasta',
                'categorie' => 'Droogwaren',
                'ean' => '8711000000011',
                'aantal' => 50,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'naam' => 'Rijst',
                'categorie' => 'Droogwaren',
                'ean' => '8711000000012',
                'aantal' => 42,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'naam' => 'Tomatensaus',
                'categorie' => 'Conserven',
                'ean' => '8711000000013',
                'aantal' => 36,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'naam' => 'Bonen',
                'categorie' => 'Conserven',
                'ean' => '8711000000014',
                'aantal' => 30,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'naam' => 'Appelsap',
                'categorie' => 'Dranken',
                'ean' => '8711000000015',
                'aantal' => 24,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('products')->insert($producten);

        $productIds = DB::table('products')
            ->orderBy('id')
            ->pluck('id', 'ean');

        DB::table('voorraad')->insert([
            [
                'product_id' => $productIds['8711000000011'],
                'hoeveelheid' => 45,
                'locatie' => 'A1',
                'vervaldatum' => '2027-02-15',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => $productIds['8711000000012'],
                'hoeveelheid' => 38,
                'locatie' => 'A2',
                'vervaldatum' => '2027-03-10',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => $productIds['8711000000013'],
                'hoeveelheid' => 32,
                'locatie' => 'B1',
                'vervaldatum' => '2026-12-01',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => $productIds['8711000000014'],
                'hoeveelheid' => 27,
                'locatie' => 'B2',
                'vervaldatum' => '2026-11-20',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
