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
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->id();

            // Qual produto foi movimentado
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            // Qual lote foi movimentado (opcional)
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('set null');

            // Qual usuário (gerente) registrou a movimentação
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Tipo da movimentação: entrada, saida, doacao, descarte
            $table->enum('tipo', ['entrada', 'saida', 'doacao', 'descarte']);

            // Quantidade movimentada
            $table->integer('quantidade')->unsigned();

            // Motivo ou observação da movimentação
            $table->text('observacao')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacoes');
    }
};
