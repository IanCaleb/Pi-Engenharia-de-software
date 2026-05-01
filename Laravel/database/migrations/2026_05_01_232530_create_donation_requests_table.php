<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donation_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('donation_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('donatario_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->enum('status', [
                'pendente',
                'aceito',
                'recusado',
                'concluido'
            ])->default('pendente');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_requests');
    }
};