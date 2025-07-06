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
            'name' => fake()->company(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->streetName(),
            'house_number' => fake()->buildingNumber(),
            'neighborhood' => fake()->citySuffix(),
            'city' => fake()->city(),
            'uf' => fake()->stateAbbr(),
            'document_type' => fake()->randomElement(['CNPJ', 'CPF']),
            'document_number' => fake()->numerify('###########'),
        ];
    }
}
