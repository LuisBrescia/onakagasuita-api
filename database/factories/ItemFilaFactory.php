<?php

namespace Database\Factories;

use App\Models\ItemFila;
use App\Models\Unidade;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemFila>
 */
class ItemFilaFactory extends Factory
{
    protected $model = ItemFila::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unidade_id' => Unidade::factory(), // Cria uma unidade relacionada
            'cliente_id' => Cliente::factory(), // Cria um cliente relacionado
            'numero_pessoas' => $this->faker->numberBetween(1, 10),
            'tempo_na_fila' => $this->faker->numberBetween(0, 120), // Tempo em minutos
        ];
    }
}