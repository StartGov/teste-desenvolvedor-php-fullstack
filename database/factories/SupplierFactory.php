<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'document_number' => $this->faker->numerify('########0001##'),
            'company_name' => $this->faker->company,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'zipcode' => $this->faker->postcode,
            'address' => $this->faker->streetName,
            'address_number' => $this->faker->buildingNumber,
            'address_complement' => $this->faker->secondaryAddress,
            'neighborhood' => $this->faker->word,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
        ];
    }
}
