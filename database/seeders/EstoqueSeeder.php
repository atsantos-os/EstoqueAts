<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstoqueSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estoque')->insert([
            ['id_produto' => 1, 'quantidade' => 120],
            ['id_produto' => 2, 'quantidade' => 80],
            ['id_produto' => 3, 'quantidade' => 60],
            ['id_produto' => 4, 'quantidade' => 45],
            ['id_produto' => 5, 'quantidade' => 200],
            ['id_produto' => 6, 'quantidade' => 30],
            ['id_produto' => 7, 'quantidade' => 90],
            ['id_produto' => 8, 'quantidade' => 15],
            ['id_produto' => 9, 'quantidade' => 75],
            ['id_produto' => 10, 'quantidade' => 50],
            ['id_produto' => 11, 'quantidade' => 110],
            ['id_produto' => 12, 'quantidade' => 25],
        ]);
    }
}
