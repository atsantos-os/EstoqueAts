<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produtos')->insert([
            ['codigo_produto' => '001', 'nome_produto' => 'Capacete de Segurança', 'descricao_produto' => 'Capacete de proteção contra impactos, cor amarela', 'condicao' => 'NOVO', 'tamanho' => 'Único', 'preco_produto' => 49.90, 'id_categoria' => 2, 'id_fornecedor' => 4],
            ['codigo_produto' => '002', 'nome_produto' => 'Calça de Uniforme Azul', 'descricao_produto' => 'Calça de uniforme profissional, tecido resistente', 'condicao' => 'NOVO', 'tamanho' => 'M', 'preco_produto' => 69.90, 'id_categoria' => 3, 'id_fornecedor' => 3],
            ['codigo_produto' => '003', 'nome_produto' => 'Calça Jeans Industrial', 'descricao_produto' => 'Calça jeans resistente para trabalho', 'condicao' => 'NOVO', 'tamanho' => 'M', 'preco_produto' => 89.90, 'id_categoria' => 2, 'id_fornecedor' => 3],
            ['codigo_produto' => '004', 'nome_produto' => 'Bota de Segurança', 'descricao_produto' => 'Bota de segurança com biqueira de aço', 'condicao' => 'NOVO', 'tamanho' => '42', 'preco_produto' => 120.00, 'id_categoria' => 3, 'id_fornecedor' => 4],
            ['codigo_produto' => '005', 'nome_produto' => 'Luva de Raspa', 'descricao_produto' => 'Luva de raspa para proteção das mãos', 'condicao' => 'NOVO', 'tamanho' => 'Único', 'preco_produto' => 15.50, 'id_categoria' => 4, 'id_fornecedor' => 5],
            ['codigo_produto' => '006', 'nome_produto' => 'Capacete Amarelo', 'descricao_produto' => 'Capacete de segurança amarelo', 'condicao' => 'NOVO', 'tamanho' => 'Único', 'preco_produto' => 49.90, 'id_categoria' => 5, 'id_fornecedor' => 6],
            ['codigo_produto' => '007', 'nome_produto' => 'Óculos Incolor', 'descricao_produto' => 'Óculos de proteção incolor', 'condicao' => 'NOVO', 'tamanho' => 'Único', 'preco_produto' => 19.90, 'id_categoria' => 6, 'id_fornecedor' => 7],
            ['codigo_produto' => '008', 'nome_produto' => 'Avental PVC', 'descricao_produto' => 'Avental de PVC para proteção', 'condicao' => 'NOVO', 'tamanho' => 'Único', 'preco_produto' => 29.90, 'id_categoria' => 7, 'id_fornecedor' => 8],
            ['codigo_produto' => '009', 'nome_produto' => 'Máscara PFF2', 'descricao_produto' => 'Máscara PFF2 para proteção respiratória', 'condicao' => 'NOVO', 'tamanho' => 'Único', 'preco_produto' => 7.90, 'id_categoria' => 8, 'id_fornecedor' => 9],
            ['codigo_produto' => '010', 'nome_produto' => 'Cinto de Segurança', 'descricao_produto' => 'Cinto de segurança para trabalho em altura', 'condicao' => 'NOVO', 'tamanho' => 'Único', 'preco_produto' => 150.00, 'id_categoria' => 9, 'id_fornecedor' => 10],
            ['codigo_produto' => '011', 'nome_produto' => 'Protetor Auricular', 'descricao_produto' => 'Protetor auricular para redução de ruído', 'condicao' => 'NOVO', 'tamanho' => 'Único', 'preco_produto' => 5.90, 'id_categoria' => 10, 'id_fornecedor' => 11],
            ['codigo_produto' => '012', 'nome_produto' => 'Jaqueta Térmica', 'descricao_produto' => 'Jaqueta térmica para proteção contra frio', 'condicao' => 'NOVO', 'tamanho' => 'M', 'preco_produto' => 99.90, 'id_categoria' => 11, 'id_fornecedor' => 12],
            ['codigo_produto' => '013', 'nome_produto' => 'Protetor Solar', 'descricao_produto' => 'Protetor solar para uso externo', 'condicao' => 'NOVO', 'tamanho' => '200ml', 'preco_produto' => 29.90, 'id_categoria' => 12, 'id_fornecedor' => 1],
            ['codigo_produto' => '014', 'nome_produto' => 'Colete Refletivo', 'descricao_produto' => 'Colete refletivo para segurança', 'condicao' => 'NOVO', 'tamanho' => 'Único', 'preco_produto' => 39.90, 'id_categoria' => 13, 'id_fornecedor' => 2],
            ['codigo_produto' => '015', 'nome_produto' => 'Calçado Antiderrapante', 'descricao_produto' => 'Calçado antiderrapante para áreas úmidas', 'condicao' => 'NOVO', 'tamanho' => '40', 'preco_produto' => 89.90, 'id_categoria' => 14, 'id_fornecedor' => 3],
        ]);
}
}