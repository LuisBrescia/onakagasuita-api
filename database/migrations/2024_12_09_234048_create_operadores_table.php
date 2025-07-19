<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('operadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unidade_id')->constrained('unidades')->onDelete('cascade');
            $table->string('login');
            $table->string('label');
            $table->string('senha');
            $table->string('token')->nullable();
            $table->string('icon')->default('desktop');
            $table->boolean('ativo')->default(true);
            $table->time('horario_ativo_inicio')->nullable();
            $table->time('horario_ativo_fim')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operadores');
    }
};
