<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travel_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Creio que somente o id do usuário seria suficiente, porém conforme solicitado adicionei uma coluna para armazenar o nome do solicitante
            $table->string('requester_name');
            $table->string('destination');
            $table->date('departure_date');
            $table->date('return_date');
            $table->enum('status', ['solicitado', 'aprovado', 'cancelado'])->default('solicitado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_requests');
    }
};
