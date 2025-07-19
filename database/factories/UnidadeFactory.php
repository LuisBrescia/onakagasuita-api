<?php

namespace Database\Factories;

use App\Models\Unidade;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\UsuarioTipo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unidade>
 */
class UnidadeFactory extends Factory
{
    protected $model = Unidade::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'franquia_id' => null,
            'nome_fantasia' => $this->faker->company,
            'cidade' => $this->faker->city,
            'logradouro' => $this->faker->streetAddress,
            'cep' => $this->faker->postcode,
            'telefone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'foto' => $this->faker->imageUrl(200, 200, 'places', true, 'Foto'),
            'ativo' => $this->faker->boolean(80), // 80% de chance de ser true
        ];
    }

    /**
     * Configura o factory para adicionar relações após a criação.
     */
    public function configure()
    {
        return $this->afterCreating(function (Unidade $unidade) {
            $numeroFixo = 1;
            $numerosPossiveis = range(2, 11);
            shuffle($numerosPossiveis);
            $numerosAleatorios = array_slice($numerosPossiveis, 0, 2);
            $usuarioIds = array_merge([$numeroFixo], $numerosAleatorios);

            // Verifica se os usuários existem
            $usuariosExistentes = Usuario::whereIn('id', $usuarioIds)->get();

            foreach ($usuariosExistentes as $usuario) {
                // Selecionar um tipo aleatório do Enum
                $tipo = $this->faker->randomElement(UsuarioTipo::cases());

                // Anexa o usuário com o tipo específico
                $unidade->usuarios()->attach($usuario->id, [
                    'tipo' => $tipo->value,
                ]);
            }
        });
    }
}
