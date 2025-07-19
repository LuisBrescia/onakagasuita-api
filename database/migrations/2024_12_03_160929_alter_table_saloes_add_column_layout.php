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
        Schema::table('saloes', function (Blueprint $table) {
            $table->json('layout')->nullable()->after('dias_funcionamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saloes', function (Blueprint $table) {
            $table->dropColumn('layout');
        });
    }
};
