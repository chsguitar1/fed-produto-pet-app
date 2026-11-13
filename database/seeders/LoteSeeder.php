<?php

namespace Database\Seeders;

use App\Models\Lote;
use Illuminate\Database\Seeder;

class LoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($number = 1; $number <= 12; $number++) {
            Lote::factory()->create([
                'numero_lote' => sprintf('LOTE-2026-%04d', $number),
            ]);
        }
    }
}
