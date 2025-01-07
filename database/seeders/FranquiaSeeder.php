<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Franquia;

class FranquiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Franquia::factory()
            ->count(5) // Número de franquias a serem criadas
            ->withUnidades() // Cada franquia terá entre 3 e 11 unidades
            ->create();
    }
}
