<?php

namespace Database\Factories;

use App\Models\Maquinario;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaquinarioFactory extends Factory
{
    protected $model = Maquinario::class;

    public function definition(): array
    {
        return [
            'maquina' => $this->faker->word(),
            'marca' => $this->faker->company(),
            'modelo' => $this->faker->bothify('Modelo-###'),
            'id_fornecedor' => null, // Ajuste se quiser vincular
            'id_cliente' => null, // Ajuste se quiser vincular
            'supervisor' => $this->faker->name(),
            'cor' => $this->faker->safeColorName(),
            'patrimonio' => $this->faker->unique()->bothify('PAT-#####'),
            'valor' => $this->faker->randomFloat(2, 1000, 10000),
            'contrato' => $this->faker->bothify('CTR-####'),
            'local' => $this->faker->city(),
            'volts' => $this->faker->randomElement(['110V', '220V']),
            'conferencia' => $this->faker->word(),
            'observacao' => $this->faker->sentence(),
            'data_saida' => $this->faker->date(),
        ];
    }
}
