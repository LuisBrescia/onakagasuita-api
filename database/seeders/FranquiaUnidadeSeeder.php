<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Franquia;
use App\Models\Unidade;

class FranquiaUnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar a franquia
        $franquia = Franquia::create([
            'nome_fantasia' => 'Franquia Exemplo',
            'categoria' => 'Comida Rápida',
            'descricao' => 'Uma franquia de exemplo para seeding.',
            'info_adicional' => 'Informações adicionais sobre a franquia.',
            'logo' => 'https://via.placeholder.com/150',
        ]);

        // Criar duas unidades associadas à franquia
        Unidade::create([
            'franquia_id' => $franquia->id,
            'nome_fantasia' => 'Unidade 1',
            'cidade' => 'Cidade A',
            'logradouro' => 'Rua 123, Bairro ABC',
            'cep' => '12345-678',
            'telefone' => '(11) 1234-5678',
            'email' => 'unidade1@exemplo.com',
            'foto' => 'https://via.placeholder.com/150',
            'ativo' => true,
        ]);

        Unidade::create([
            'franquia_id' => $franquia->id,
            'nome_fantasia' => 'Unidade 2',
            'cidade' => 'Cidade B',
            'logradouro' => 'Rua 456, Bairro DEF',
            'cep' => '98765-432',
            'telefone' => '(11) 8765-4321',
            'email' => 'unidade2@exemplo.com',
            'foto' => 'https://via.placeholder.com/150',
            'ativo' => true,
        ]);
    }
}
