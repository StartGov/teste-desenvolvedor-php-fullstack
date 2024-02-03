<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cpf_cnpj'      => $this->faker->unique()->numberBetween(10000000000, 99999999999999),
            'nome_fantasia' => $this->faker->name,
            'razao_social'  => $this->faker->name,
            'contato'       => $this->faker->phoneNumber,
            'endereco'      => $this->faker->streetAddress,
            'numero'        => $this->faker->numberBetween(1, 500),
        ];
    }
}
