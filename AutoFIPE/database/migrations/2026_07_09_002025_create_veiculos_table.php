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
        Schema::create('veiculos', function (Blueprint $table) {

            $table->id();

            // Relação com a FIPE
            $table->foreignId('fipe_veiculo_id')
                ->constrained('fipe_veiculos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Identificação
            $table->string('placa', 8)->nullable()->unique();
            $table->string('renavam')->nullable()->unique();
            $table->string('chassi')->nullable()->unique();

            // Dados do veículo
            $table->string('cor', 50);
            $table->integer('quilometragem')->default(0);
            $table->year('ano_fabricacao')->nullable();

            // Financeiro
            $table->decimal('valor_compra', 12, 2)->nullable();
            $table->decimal('valor_venda', 12, 2)->nullable();

            // Controle
            $table->boolean('ativo')->default(true);
            $table->text('observacoes')->nullable();

            $table->timestamps();

            $table->index('ativo');
            $table->index('quilometragem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};
