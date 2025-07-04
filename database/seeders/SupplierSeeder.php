<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        for ($i = 0; $i < 50; $i++) {
            Supplier::create([
                'document_number' => $faker->cnpj(false),
                'company_name' => $faker->company,
                'email' => $faker->companyEmail,
                'phone' => $faker->phoneNumber,
                'zipcode' => $faker->postcode,
                'address' => $faker->streetName,
                'address_number' => $faker->buildingNumber,
                'address_complement' => $faker->optional()->secondaryAddress,
                'neighborhood' => $faker->streetSuffix,
                'city' => $faker->city,
                'state' => $faker->stateAbbr,
            ]);
        }
    }
}
