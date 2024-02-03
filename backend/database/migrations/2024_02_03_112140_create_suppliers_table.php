<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('cpf_cnpj', 15)->unique()->index();
            $table->string('nome_fantasia');
            $table->string('razao_social');
            $table->string('contato');
            $table->string('endereco');
            $table->string('numero');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
