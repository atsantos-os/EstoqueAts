<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clientes')->insert([
            [ 'cnpj' => '12.345.678/0001-00', 'razao_social' => 'Empresa Alpha Ltda', 'nome_fantasia' => 'Alpha', 'contrato' => 'Contrato A', 'supervisor' => 'Supervisor A' ],
            [ 'cnpj' => '98.765.432/0001-99', 'razao_social' => 'Beta Comércio S.A.', 'nome_fantasia' => 'Beta', 'contrato' => 'Contrato B', 'supervisor' => 'Supervisor B' ],
            [ 'cnpj' => '11.222.333/0001-44', 'razao_social' => 'Gamma Serviços ME', 'nome_fantasia' => 'Gamma', 'contrato' => 'Contrato C', 'supervisor' => 'Supervisor C' ],
            [ 'cnpj' => '55.666.777/0001-88', 'razao_social' => 'Delta Indústria EIRELI', 'nome_fantasia' => 'Delta', 'contrato' => 'Contrato D', 'supervisor' => 'Supervisor D' ],
            [ 'cnpj' => '99.888.777/0001-66', 'razao_social' => 'Epsilon Transportes Ltda', 'nome_fantasia' => 'Epsilon', 'contrato' => 'Contrato E', 'supervisor' => 'Supervisor E' ],
            [ 'cnpj' => '22.333.444/0001-55', 'razao_social' => 'Zeta Soluções Ltda', 'nome_fantasia' => 'Zeta', 'contrato' => 'Contrato F', 'supervisor' => 'Supervisor F' ],
            [ 'cnpj' => '33.444.555/0001-66', 'razao_social' => 'Eta Engenharia S.A.', 'nome_fantasia' => 'Eta', 'contrato' => 'Contrato G', 'supervisor' => 'Supervisor G' ],
            [ 'cnpj' => '44.555.666/0001-77', 'razao_social' => 'Theta Consultoria ME', 'nome_fantasia' => 'Theta', 'contrato' => 'Contrato H', 'supervisor' => 'Supervisor H' ],
            [ 'cnpj' => '66.777.888/0001-99', 'razao_social' => 'Iota Comércio Ltda', 'nome_fantasia' => 'Iota', 'contrato' => 'Contrato I', 'supervisor' => 'Supervisor I' ],
            [ 'cnpj' => '77.888.999/0001-00', 'razao_social' => 'Kappa Serviços EIRELI', 'nome_fantasia' => 'Kappa', 'contrato' => 'Contrato J', 'supervisor' => 'Supervisor J' ],
        ]);
    }
}
