<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovimentacaoEstoqueSeeder extends Seeder
{
    public function run(): void
    {
        $movs = [
            ['id_produto' => 1, 'id_cliente' => 1, 'tipo_movimentacao' => 'ENTRADA', 'quantidade' => 20, 'data_solicitacao' => '2025-09-08', 'data_entrega' => '2025-09-08', 'retirada_por' => 2, 'observacao' => 'Entrada inicial'], // João
            ['id_produto' => 2, 'id_cliente' => 2, 'tipo_movimentacao' => 'SAIDA', 'quantidade' => 10, 'data_solicitacao' => '2025-09-08', 'data_entrega' => '2025-09-08', 'retirada_por' => 3, 'observacao' => 'Saída para cliente'], // Maria
            ['id_produto' => 3, 'id_cliente' => 3, 'tipo_movimentacao' => 'ENTRADA', 'quantidade' => 15, 'data_solicitacao' => '2025-09-09', 'data_entrega' => '2025-09-09', 'retirada_por' => 4, 'observacao' => 'Reposição'], // Bruno
            ['id_produto' => 4, 'id_cliente' => 4, 'tipo_movimentacao' => 'SAIDA', 'quantidade' => 5, 'data_solicitacao' => '2025-09-10', 'data_entrega' => '2025-09-10', 'retirada_por' => 5, 'observacao' => 'Saída para cliente'], // Fernanda
            ['id_produto' => 5, 'id_cliente' => 5, 'tipo_movimentacao' => 'ENTRADA', 'quantidade' => 50, 'data_solicitacao' => '2025-09-11', 'data_entrega' => '2025-09-11', 'retirada_por' => 6, 'observacao' => 'Compra nova'], // Juliana
            ['id_produto' => 6, 'id_cliente' => 6, 'tipo_movimentacao' => 'SAIDA', 'quantidade' => 8, 'data_solicitacao' => '2025-09-12', 'data_entrega' => '2025-09-12', 'retirada_por' => 7, 'observacao' => 'Saída para cliente'], // Lucas
            ['id_produto' => 7, 'id_cliente' => 7, 'tipo_movimentacao' => 'ENTRADA', 'quantidade' => 30, 'data_solicitacao' => '2025-09-13', 'data_entrega' => '2025-09-13', 'retirada_por' => 8, 'observacao' => 'Reposição'], // Patrícia
            ['id_produto' => 8, 'id_cliente' => 8, 'tipo_movimentacao' => 'SAIDA', 'quantidade' => 12, 'data_solicitacao' => '2025-09-14', 'data_entrega' => '2025-09-14', 'retirada_por' => 9, 'observacao' => 'Saída para cliente'], // Rafael
            ['id_produto' => 9, 'id_cliente' => 9, 'tipo_movimentacao' => 'ENTRADA', 'quantidade' => 25, 'data_solicitacao' => '2025-09-15', 'data_entrega' => '2025-09-15', 'retirada_por' => 10, 'observacao' => 'Compra nova'], // Sofia
            ['id_produto' => 10, 'id_cliente' => 10, 'tipo_movimentacao' => 'SAIDA', 'quantidade' => 7, 'data_solicitacao' => '2025-09-16', 'data_entrega' => '2025-09-16', 'retirada_por' => 11, 'observacao' => 'Saída para cliente'], // Thiago
        ];
        DB::table('movimentacoes_estoque')->insert($movs);
    }
}
