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
        Schema::create('fipe_veiculos', function (Blueprint $table) {

            $table->id();

            // Código oficial FIPE
            $table->string('codigo_fipe')->unique();

            // Dados da FIPE
            $table->enum('tipo', [
                'carros',
                'motos',
                'caminhoes'
            ]);

            $table->string('marca');
            $table->string('modelo');
            $table->string('ano_modelo', 20);
            $table->string('combustivel', 30);

            // Opcional
            $table->string('referencia')->nullable();

            $table->timestamps();

            $table->index(['marca', 'modelo']);
            $table->index('tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fipe_veiculos');
    }
};
