<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nome_categoria' => 'Alimentos'],
            ['nome_categoria' => 'Limpeza'],
            ['nome_categoria' => 'Bebidas'],
            ['nome_categoria' => 'Higiene'],
            ['nome_categoria' => 'Uniformes'],
            ['nome_categoria' => 'Calçados'],
            ['nome_categoria' => 'Luvas'],
            ['nome_categoria' => 'Capacetes'],
            ['nome_categoria' => 'Óculos de Proteção'],
            ['nome_categoria' => 'Aventais'],
            ['nome_categoria' => 'Máscaras'],
            ['nome_categoria' => 'Cintos de Segurança'],
            ['nome_categoria' => 'Protetores Auriculares'],
            ['nome_categoria' => 'Jaquetas'],
            ['nome_categoria' => 'Ferramentas'],
            ['nome_categoria' => 'Materiais de Escritório'],
            ['nome_categoria' => 'Eletrônicos'],
            ['nome_categoria' => 'Medicamentos'],
            ['nome_categoria' => 'Proteção Solar'],
        ];
        DB::table('categorias')->insert($categorias);
    }
}
