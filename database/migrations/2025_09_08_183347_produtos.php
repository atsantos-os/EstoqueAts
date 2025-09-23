<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id('id_produto');
            $table->string('codigo_produto', 50)->unique();
            $table->string('nome_produto', 255);
            $table->text('descricao_produto')->nullable();
            $table->enum('condicao', ['NOVO', 'USADO']);
            $table->string('tamanho', 20)->nullable();
            $table->decimal('preco_produto', 10, 2)->nullable();
            $table->unsignedBigInteger('id_categoria')->nullable();
            $table->unsignedBigInteger('id_fornecedor')->nullable();
            $table->integer('quantidade_minima')->default(10); // Estoque mínimo para considerar "em baixa"
            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_atualizacao')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_categoria')->references('id_categoria')->on('categorias');
            $table->foreign('id_fornecedor')->references('id_fornecedor')->on('fornecedores');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
