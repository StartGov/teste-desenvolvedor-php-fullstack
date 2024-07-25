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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 256);
            $table->string('description', 256);
            $table->string('document_number', 20)->unique(true);
            $table->string('email', 256)->unique(true);
            $table->string('phone', 20);
            $table->enum('document_type', ['CPF', 'CNPJ']);
            $table->unsignedBigInteger('address_id')->nullable(true);
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
