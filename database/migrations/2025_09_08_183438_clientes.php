<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('id_cliente');
            $table->string('cnpj', 18)->unique(); // CNPJ da empresa
            $table->string('razao_social', 255); // Razão social da empresa
            $table->string('nome_fantasia', 255)->nullable(); // Nome fantasia
            $table->string('contrato', 100)->nullable();
            $table->string('supervisor', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
