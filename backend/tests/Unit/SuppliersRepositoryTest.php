<?php

use App\Models\Supplier;
use App\Models\Address;
use App\Repositories\Implements\SuppliersRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class SuppliersRepositoryTest extends TestCase
{
    /** @test */
    public function it_can_create_a_supplier_with_address()
    {
        $data = [
            'social_reason' => 'Empresa XYZ',
            'fantasy_name' => 'XYZ LTDA',
            'contact' => 'João da Silva',
            'cnpj' => '12345678901234',
            'address' => [
                'address' => 'Rua ABC',
                'number' => '123',
                'neighborhood' => 'Centro',
                'city' => 'Cidade',
                'state' => 'UF',
                'cep' => '12345-678',
            ],
        ];

        $repository = new SuppliersRepository();

        $supplier = $repository->create($data);

        $this->assertInstanceOf(Supplier::class, $supplier);
        $this->assertEquals($data['social_reason'], $supplier->social_reason);
        $this->assertEquals($data['fantasy_name'], $supplier->fantasy_name);
        $this->assertEquals($data['contact'], $supplier->contact);
        $this->assertEquals($data['cnpj'], $supplier->cnpj);

        $this->assertInstanceOf(Address::class, $supplier->address);
        $this->assertEquals($data['address']['address'], $supplier->address->addres);
        $this->assertEquals($data['address']['number'], $supplier->address->number);
        $this->assertEquals($data['address']['neighborhood'], $supplier->address->neighborhood);
        $this->assertEquals($data['address']['city'], $supplier->address->city);
        $this->assertEquals($data['address']['state'], $supplier->address->state);
        $this->assertEquals($data['address']['cep'], $supplier->address->cep);
    }

    /** @test */
    public function it_can_update_a_supplier_with_address()
    {
        $supplier = Supplier::factory()->create();
        $supplier->save();

        $data = [
            'social_reason' => 'Nova Razão Social',
            'fantasy_name' => 'Novo Nome Fantasia',
            'contact' => 'Novo Contato',
            'cnpj' => '98765432109876',
            'address' => [
                'addres' => 'Nova Rua',
                'number' => '456',
                'neighborhood' => 'Novo Bairro',
                'city' => 'Nova Cidade',
                'state' => 'NO',
                'cep' => '54321-987',
            ],
        ];

        $repository = new SuppliersRepository();

        $updatedSupplier = $repository->update($data, $supplier->id);

        $this->assertInstanceOf(Supplier::class, $updatedSupplier);
        $this->assertEquals($data['social_reason'], $updatedSupplier->social_reason);
        $this->assertEquals($data['fantasy_name'], $updatedSupplier->fantasy_name);
        $this->assertEquals($data['contact'], $updatedSupplier->contact);
        $this->assertEquals($data['cnpj'], $updatedSupplier->cnpj);

        $updatedAddress = $updatedSupplier->address;
        $this->assertInstanceOf(Address::class, $updatedAddress);
        $this->assertEquals($data['address']['addres'], $updatedAddress->addres);
        $this->assertEquals($data['address']['number'], $updatedAddress->number);
        $this->assertEquals($data['address']['neighborhood'], $updatedAddress->neighborhood);
        $this->assertEquals($data['address']['city'], $updatedAddress->city);
        $this->assertEquals($data['address']['state'], $updatedAddress->state);
        $this->assertEquals($data['address']['cep'], $updatedAddress->cep);
    }

    /** @test */
    public function it_can_find_supplier_by_id()
    {
        $supplier = Supplier::factory()->create();

        $repository = new SuppliersRepository();

        $foundSupplier = $repository->findById($supplier->id);

        $this->assertInstanceOf(Supplier::class, $foundSupplier);
        $this->assertEquals($supplier->id, $foundSupplier->id);
    }

    /** @test */
    public function it_throws_exception_when_supplier_not_found()
    {
        $invalidId = 999999;

        $repository = new SuppliersRepository();

        $this->expectException(ModelNotFoundException::class);
        $repository->findById($invalidId);
    }
}
