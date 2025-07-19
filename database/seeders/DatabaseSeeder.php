<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use App\Enums\UsuarioStatus;
use App\Enums\UsuarioTipo;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Usuario::factory()->create([
            'nome' => 'Admin',
            'email' => 'admin@admin.com',
            'senha' => 'admin',
            'status' => UsuarioStatus::Ativo,
            'tipo' => UsuarioTipo::Admin,
        ]);
        Usuario::factory(10)->create();
        $this->call([
            FranquiaUnidadeSeeder::class,
            FranquiaSeeder::class,
        ]);
    }
}
