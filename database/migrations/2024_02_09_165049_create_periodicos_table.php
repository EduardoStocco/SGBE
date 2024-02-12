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
        Schema::create('periodicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('tipo'); // Ex: revista, jornal
            $table->text('descricao')->nullable();
            $table->date('data_inicio_assinatura')->nullable();
            $table->date('data_fim_assinatura')->nullable(); // Se for nulo, a assinatura está ativa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodicos');
    }
};
