<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagens_veiculo', function (Blueprint $table) {
            $table->id();

            $table->foreignId('veiculo_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('url');
            $table->string('public_id')->nullable();
            $table->boolean('principal')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagens_veiculo');
    }
};
