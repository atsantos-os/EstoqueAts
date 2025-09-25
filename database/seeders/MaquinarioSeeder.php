<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Maquinario;

class MaquinarioSeeder extends Seeder
{
    public function run(): void
    {
        Maquinario::factory()->count(10)->create();
    }
}
