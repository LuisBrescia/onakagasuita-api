<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemFila;

class ItemFilaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemFila::factory()
            ->count(50) // Quantidade de itens na fila a serem criados
            ->create();
    }
}