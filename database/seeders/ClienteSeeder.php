<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clientes')->insert([
            ['cpf' => '123.456.789-00', 'primeiro_nome' => 'Carlos', 'contrato' => 'Contrato 1', 'supervisor' => 'Supervisor 1'],
            ['cpf' => '987.654.321-00', 'primeiro_nome' => 'Ana', 'contrato' => 'Contrato 2', 'supervisor' => 'Supervisor 2'],
            ['cpf' => '111.222.333-44', 'primeiro_nome' => 'Bruno', 'contrato' => 'Contrato 3', 'supervisor' => 'Supervisor 3'],
            ['cpf' => '555.666.777-88', 'primeiro_nome' => 'Fernanda', 'contrato' => 'Contrato 4', 'supervisor' => 'Supervisor 4'],
            ['cpf' => '999.888.777-66', 'primeiro_nome' => 'Juliana', 'contrato' => 'Contrato 5', 'supervisor' => 'Supervisor 5'],
            ['cpf' => '222.333.444-55', 'primeiro_nome' => 'Lucas', 'contrato' => 'Contrato 6', 'supervisor' => 'Supervisor 6'],
            ['cpf' => '333.444.555-66', 'primeiro_nome' => 'Patrícia', 'contrato' => 'Contrato 7', 'supervisor' => 'Supervisor 7'],
            ['cpf' => '444.555.666-77', 'primeiro_nome' => 'Rafael', 'contrato' => 'Contrato 8', 'supervisor' => 'Supervisor 8'],
            ['cpf' => '666.777.888-99', 'primeiro_nome' => 'Sofia', 'contrato' => 'Contrato 9', 'supervisor' => 'Supervisor 9'],
            ['cpf' => '777.888.999-00', 'primeiro_nome' => 'Thiago', 'contrato' => 'Contrato 10', 'supervisor' => 'Supervisor 10'],
            ['cpf' => '888.999.000-11', 'primeiro_nome' => 'Gabriela', 'contrato' => 'Contrato 11', 'supervisor' => 'Supervisor 11'],
            ['cpf' => '999.000.111-22', 'primeiro_nome' => 'Marcos', 'contrato' => 'Contrato 12', 'supervisor' => 'Supervisor 12'],
        ]);
    }
}
