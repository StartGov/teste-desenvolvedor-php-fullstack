<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Http\Controllers\SupplierController;
use App\Http\Requests\StoreSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Repositories\SuppliersRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;

class SupplierControllerTest extends TestCase
{
    use RefreshDatabase; // Use this if you're working with a database
    use WithFaker; // Use this if you need to generate fake data

    protected $suppliersRepositoryMock;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->suppliersRepositoryMock = $this->createMock(SuppliersRepositoryInterface::class);
        $this->controller = new SupplierController($this->suppliersRepositoryMock);
    }

    /** @test */
    public function store_method_creates_supplier_and_returns_json_response()
    {
        $requestData = [
            'social_reason' => $this->faker->company,
            'fantasy_name' => $this->faker->companySuffix,
            'contact' => $this->faker->name,
            'cnpj' => $this->faker->unique()->ean13,
            'address' => [
                'address' => $this->faker->streetAddress,
                'number' => $this->faker->buildingNumber,
                'neighborhood' => $this->faker->citySuffix,
                'city' => $this->faker->city,
                'state' => $this->faker->stateAbbr,
                'cep' => $this->faker->postcode,
            ]
        ];

        $this->suppliersRepositoryMock->expects($this->once())
            ->method('create')
            ->with($requestData)
            ->willReturn(new Supplier($requestData));

        $request = new StoreSupplierRequest($requestData);
        $response = $this->controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    /** @test */
    public function store_method_fails_when_cnpj_is_not_provided()
    {
        // Criar uma solicitação sem o campo 'cnpj'
        $requestData = [
            'social_reason' => $this->faker->company,
            'fantasy_name' => $this->faker->companySuffix,
            'contact' => $this->faker->name,
            'address' => [
                'address' => $this->faker->streetAddress,
                'number' => $this->faker->buildingNumber,
                'neighborhood' => $this->faker->citySuffix,
                'city' => $this->faker->city,
                'state' => $this->faker->stateAbbr,
                'cep' => $this->faker->postcode,
            ]
        ];

        $response = $this->postJson('/api/suppliers', $requestData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJson([
            'cnpj' => ['O campo cnpj é obrigatório.']
        ]);
    }

}
