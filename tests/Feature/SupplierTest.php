<?php

use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can list suppliers', function () {
    Supplier::factory()->count(3)->create();

    $response = $this->getJson('/api/suppliers');

    $response->assertOk()
             ->assertJsonStructure([
                 'data' => [
                     '*' => ['id', 'document_number', 'company_name', 'email', 'phone']
                 ]
             ]);
});

it('can create a supplier', function () {
    $data = [
        'document_number' => '12345678000195',
        'company_name' => 'Test Company',
        'email' => 'test@example.com',
        'phone' => '(31) 99999-9999',
        'zipcode' => '30130-000',
        'address' => 'Rua Teste',
        'address_number' => '123',
        'address_complement' => 'Sala 1',
        'neighborhood' => 'Centro',
        'city' => 'Belo Horizonte',
        'state' => 'MG',
    ];

    $response = $this->postJson('/api/suppliers', $data);

    $response->assertCreated()
             ->assertJsonPath('data.company_name', 'Test Company');

    $this->assertDatabaseHas('suppliers', ['document_number' => '12345678000195']);
});

it('validates required fields on create', function () {
    $response = $this->postJson('/api/suppliers', []);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['document_number', 'company_name']);
});

it('can update a supplier', function () {
    $supplier = Supplier::factory()->create();

    $response = $this->putJson("/api/suppliers/{$supplier->id}", [
        'document_number' => $supplier->document_number,
        'company_name' => 'Updated Name',
    ]);

    $response->assertOk()
             ->assertJsonPath('data.company_name', 'Updated Name');

    $this->assertDatabaseHas('suppliers', ['id' => $supplier->id, 'company_name' => 'Updated Name']);
});

it('can delete a supplier', function () {
    $supplier = Supplier::factory()->create();

    $response = $this->deleteJson("/api/suppliers/{$supplier->id}");

    $response->assertNoContent();

    $this->assertDatabaseMissing('suppliers', ['id' => $supplier->id]);
});
