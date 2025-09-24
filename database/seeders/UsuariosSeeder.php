<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('usuarios')->insert([
            ['nome' => 'Dallas', 'cpf' => '000.000.000-00', 'senha' => Hash::make('123'), 'is_admin' => true, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'João', 'cpf' => '111.111.111-11', 'senha' => Hash::make('123'), 'is_admin' => false, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Maria', 'cpf' => '222.222.222-22', 'senha' => Hash::make('123'), 'is_admin' => false, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Bruno', 'cpf' => '333.333.333-33', 'senha' => Hash::make('123'), 'is_admin' => false, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Fernanda', 'cpf' => '444.444.444-44', 'senha' => Hash::make('123'), 'is_admin' => false, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Juliana', 'cpf' => '555.555.555-55', 'senha' => Hash::make('123'), 'is_admin' => false, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Lucas', 'cpf' => '666.666.666-66', 'senha' => Hash::make('123'), 'is_admin' => false, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Patrícia', 'cpf' => '777.777.777-77', 'senha' => Hash::make('123'), 'is_admin' => false, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Rafael', 'cpf' => '888.888.888-88', 'senha' => Hash::make('123'), 'is_admin' => false, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Sofia', 'cpf' => '999.999.999-99', 'senha' => Hash::make('123'), 'is_admin' => false, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Thiago', 'cpf' => '001.000.000-00', 'senha' => Hash::make('123'), 'is_admin' => false, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
