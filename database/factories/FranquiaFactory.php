<?php

namespace Database\Factories;

use App\Models\Franquia;
use App\Models\Unidade;
use Illuminate\Database\Eloquent\Factories\Factory;

class FranquiaFactory extends Factory
{
    protected $model = Franquia::class;

    public function definition()
    {
        return [
            'nome_fantasia' => $this->faker->company,
            'categoria' => $this->faker->randomElement(['Alimentação', 'Educação', 'Saúde', 'Tecnologia', 'Varejo']),
            'descricao' => $this->faker->paragraph,
            'info_adicional' => $this->faker->sentence,
            'logo' => $this->faker->imageUrl(200, 200, 'business', true, 'Logo'),
        ];
    }

    public function withUnidades()
    {
        // Gera um número aleatório entre 3 e 11
        $quantidade = rand(3, 11);

        return $this->has(
            Unidade::factory()->count($quantidade),
            'unidades'
        );
    }
}
