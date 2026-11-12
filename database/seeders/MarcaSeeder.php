<?php

namespace Database\Seeders;

use App\Models\Marca;
use Database\Factories\MarcaFactory;
use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (MarcaFactory::BRANDS as $brand) {
            Marca::factory()->create($brand);
        }
    }
}
