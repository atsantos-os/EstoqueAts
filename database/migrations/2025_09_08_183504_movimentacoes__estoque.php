<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movimentacoes_estoque', function (Blueprint $table) {
            $table->id('id_movimentacao');
            $table->unsignedBigInteger('id_produto');
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->enum('tipo_movimentacao', ['ENTRADA', 'SAIDA', 'AJUSTE']);
            $table->integer('quantidade');
            $table->date('data_solicitacao')->nullable();
            $table->date('data_entrega')->nullable();
            $table->unsignedBigInteger('retirada_por')->nullable();
            $table->text('observacao')->nullable();

            $table->foreign('id_produto')->references('id_produto')->on('produtos');
            $table->foreign('id_cliente')->references('id_cliente')->on('clientes');
            $table->foreign('retirada_por')->references('id')->on('usuarios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimentacoes_estoque');
    }
};
