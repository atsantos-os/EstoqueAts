<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Movimentacoes Estoque: FK id_cliente
        Schema::table('movimentacoes_estoque', function (Blueprint $table) {
            $table->dropForeign(['id_cliente']);
            $table->foreign('id_cliente')
                ->references('id_cliente')->on('clientes')
                ->onDelete('set null');
        });
        // Produtos: FK id_categoria, id_fornecedor
        Schema::table('produtos', function (Blueprint $table) {
            if (Schema::hasColumn('produtos', 'id_categoria')) {
                $table->dropForeign(['id_categoria']);
                $table->foreign('id_categoria')
                    ->references('id_categoria')->on('categorias')
                    ->onDelete('set null');
            }
            if (Schema::hasColumn('produtos', 'id_fornecedor')) {
                $table->dropForeign(['id_fornecedor']);
                $table->foreign('id_fornecedor')
                    ->references('id_fornecedor')->on('fornecedores')
                    ->onDelete('set null');
            }
        });
        // Maquinarios: FK id_fornecedor, id_cliente
        Schema::table('maquinarios', function (Blueprint $table) {
            $table->dropForeign(['id_fornecedor']);
            $table->foreign('id_fornecedor')
                ->references('id_fornecedor')->on('fornecedores')
                ->onDelete('set null');
            $table->dropForeign(['id_cliente']);
            $table->foreign('id_cliente')
                ->references('id_cliente')->on('clientes')
                ->onDelete('set null');
        });
        // Manutencao Maquinario: FK id_fornecedor
        Schema::table('manutencao_maquinario', function (Blueprint $table) {
            $table->dropForeign(['id_fornecedor']);
            $table->foreign('id_fornecedor')
                ->references('id_fornecedor')->on('fornecedores')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        // Não implementado: reversão manual das FKs
    }
};
