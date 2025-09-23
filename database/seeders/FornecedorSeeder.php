<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FornecedorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('fornecedores')->insert([
            ['nome_fantasia' => 'Fornecedor Exemplo 1', 'cnpj' => '12.345.678/0001-99', 'razao_social' => 'Fornecedor Exemplo 1 LTDA', 'email' => 'contato@exemplo1.com', 'telefone' => '(11) 99999-1111', 'endereco' => 'Rua Exemplo, 123', 'categoria_fornecedor' => 'Alimentos', 'responsavel' => 'João Silva'],
            ['nome_fantasia' => 'Fornecedor Exemplo 2', 'cnpj' => '98.765.432/0001-88', 'razao_social' => 'Fornecedor Exemplo 2 ME', 'email' => 'contato@exemplo2.com', 'telefone' => '(21) 88888-2222', 'endereco' => 'Avenida Teste, 456', 'categoria_fornecedor' => 'Limpeza', 'responsavel' => 'Maria Souza'],
            ['nome_fantasia' => 'Uniformes Brasil', 'cnpj' => '12.345.678/0001-01', 'razao_social' => 'Uniformes Brasil LTDA', 'email' => 'contato@uniformesbrasil.com', 'telefone' => '(11) 99999-2222', 'endereco' => 'Rua Uniforme, 456', 'categoria_fornecedor' => 'Roupas', 'responsavel' => 'Carlos Pereira'],
            ['nome_fantasia' => 'EPI Forte', 'cnpj' => '23.456.789/0001-02', 'razao_social' => 'EPI Forte LTDA', 'email' => 'contato@epiforte.com', 'telefone' => '(21) 88888-3333', 'endereco' => 'Avenida Segurança, 789', 'categoria_fornecedor' => 'EPIs', 'responsavel' => 'Ana Costa'],
            ['nome_fantasia' => 'ProtegeMais', 'cnpj' => '34.567.890/0001-03', 'razao_social' => 'ProtegeMais LTDA', 'email' => 'contato@protegemais.com', 'telefone' => '(31) 77777-4444', 'endereco' => 'Rua Proteção, 321', 'categoria_fornecedor' => 'EPIs', 'responsavel' => 'Pedro Almeida'],
            ['nome_fantasia' => 'Segurança Total', 'cnpj' => '45.678.901/0001-04', 'razao_social' => 'Segurança Total LTDA', 'email' => 'contato@segurancatotal.com', 'telefone' => '(41) 66666-5555', 'endereco' => 'Avenida Segurança Total, 654', 'categoria_fornecedor' => 'EPIs', 'responsavel' => 'Mariana Lima'],
            ['nome_fantasia' => 'WorkWear', 'cnpj' => '56.789.012/0001-05', 'razao_social' => 'WorkWear LTDA', 'email' => 'contato@workwear.com', 'telefone' => '(51) 55555-6666', 'endereco' => 'Rua Trabalho, 987', 'categoria_fornecedor' => 'Roupas', 'responsavel' => 'Roberto Santos'],
            ['nome_fantasia' => 'Safe Equipamentos', 'cnpj' => '67.890.123/0001-06', 'razao_social' => 'Safe Equipamentos LTDA', 'email' => 'contato@safeequipamentos.com', 'telefone' => '(61) 44444-7777', 'endereco' => 'Avenida Equipamentos, 123', 'categoria_fornecedor' => 'EPIs', 'responsavel' => 'Fernanda Rocha'],
            ['nome_fantasia' => 'EPI Master', 'cnpj' => '78.901.234/0001-07', 'razao_social' => 'EPI Master LTDA', 'email' => 'contato@epimaster.com', 'telefone' => '(71) 33333-8888', 'endereco' => 'Rua Mestrado, 456', 'categoria_fornecedor' => 'EPIs', 'responsavel' => 'Lucas Ferreira'],
            ['nome_fantasia' => 'Uniformiza', 'cnpj' => '89.012.345/0001-08', 'razao_social' => 'Uniformiza LTDA', 'email' => 'contato@uniformiza.com', 'telefone' => '(81) 22222-9999', 'endereco' => 'Avenida Uniformização, 789', 'categoria_fornecedor' => 'Roupas', 'responsavel' => 'Juliana Mendes'],
            ['nome_fantasia' => 'Protetor Brasil', 'cnpj' => '90.123.456/0001-09', 'razao_social' => 'Protetor Brasil LTDA', 'email' => 'contato@protetorbrasil.com', 'telefone' => '(91) 11111-0000', 'endereco' => 'Rua Protetor, 321', 'categoria_fornecedor' => 'EPIs', 'responsavel' => 'Thiago Gomes'],
            ['nome_fantasia' => 'EquipSeg', 'cnpj' => '01.234.567/0001-10', 'razao_social' => 'EquipSeg LTDA', 'email' => 'contato@equipseg.com', 'telefone' => '(01) 00000-1111', 'endereco' => 'Avenida EquipSeg, 654', 'categoria_fornecedor' => 'EPIs', 'responsavel' => 'Sofia Alves'],
        ]);
    }
}
