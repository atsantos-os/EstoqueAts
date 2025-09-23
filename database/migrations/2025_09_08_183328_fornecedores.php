<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id('id_fornecedor');
            $table->string('nome_fantasia', 255)->unique();
            $table->string('cnpj', 20)->unique()->nullable();
            $table->string('razao_social', 255)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->text('endereco')->nullable();
            $table->string('categoria_fornecedor', 100)->nullable();
            $table->string('responsavel', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fornecedores');
    }
};
