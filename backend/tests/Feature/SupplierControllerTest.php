<?php

namespace Tests\Feature;

use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('should list all suppliers', function () {
    Supplier::factory()->count(2)->create();

    $response = $this->getJson('/api/suppliers');

    $response->assertStatus(200);

    $response->assertJsonCount(2, 'data');
});

it('should create a new supplier', function () {
    $supplierData = [
        'name' => 'New Supplier',
        'phone' => '11987654321',
        'address' => [
            'street' => 'Rua Principal',
            'house_number' => '123',
            'neighborhood' => 'Centro',
            'city' => 'São Paulo',
            'state' => 'SP',
        ],
        'document_type' => 'CNPJ',
        'document_number' => '75574868000102',
    ];

    $response = $this->postJson('/api/suppliers', $supplierData);

    $response->assertStatus(201);

    $response->assertJsonFragment(['name' => 'New Supplier']);

    $this->assertDatabaseHas('suppliers', $supplierData);
});

it('should show a single supplier', function () {
    $supplier = Supplier::factory()->create();

    $response = $this->getJson('/api/suppliers/' . $supplier->id);

    $response->assertStatus(200);

    $response->assertJsonFragment(['name' => $supplier->name]);
});

it('should update a supplier', function () {
    $supplier = Supplier::factory()->create();

    $updateData = [
        'name' => 'Updated Supplier Name',
        'phone' => '11999998888',
    ];

    $response = $this->patchJson('/api/suppliers/' . $supplier->id, $updateData);

    $response->assertStatus(200);

    $response->assertJsonFragment(['name' => 'Updated Supplier Name']);

    $this->assertDatabaseHas('suppliers', [
        'id' => $supplier->id,
        'name' => 'Updated Supplier Name',
    ]);
});

it('should delete a supplier', function () {
    $supplier = Supplier::factory()->create();

    $response = $this->deleteJson('/api/suppliers/' . $supplier->id);

    $response->assertStatus(200);

    $response->assertJson(['message' => 'Supplier deleted successfully']);

    $this->assertDatabaseMissing('suppliers', ['id' => $supplier->id]);
});

it('should return 404 when trying to find a non-existent supplier', function () {
    $response = $this->getJson('/api/suppliers/999');

    $response->assertStatus(404);
});

it('should show a single supplier by document', function () {
    $supplier = Supplier::factory()->create([
        'document_type' => 'CNPJ',
        'document_number' => '33406775000109',
    ]);

    $response = $this->getJson('/api/suppliers/document?document_type=CNPJ&document_number=33406775000109');

    $response->assertStatus(200);
    $response->assertJsonFragment(['id' => $supplier->id]);
});

it('should return 404 when trying to find a supplier by a non-existent document', function () {
    $response = $this->getJson('/api/suppliers/document?document_type=CNPJ&document_number=99999999000199');

    $response->assertStatus(404);
});

it('should return 400 when document type or number are missing for document search', function () {
    $response = $this->getJson('/api/suppliers/document?document_type=CNPJ');

    $response->assertStatus(400);
    $response->assertJson(['message' => 'Document type and number are required']);
});

it('should return a validation error if required fields are missing on creation', function () {
    $supplierData = [
        // 'name' => 'Supplier Without Name',
        'phone' => '11987654321',
        'address' => '123 Main St',
        'document_type' => 'CNPJ',
        'document_number' => '33406775000109',
    ];

    $response = $this->postJson('/api/suppliers', $supplierData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('name');
});

it('should return a validation error for an invalid CPF', function () {
    $supplierData = [
        'name' => 'New Supplier',
        'phone' => '11987654321',
        'address' => '123 Main St',
        'document_type' => 'CPF',
        'document_number' => '11111111111',
    ];

    $response = $this->postJson('/api/suppliers', $supplierData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('document_number');
});

it('should filter suppliers by name', function () {
    Supplier::factory()->create(['name' => 'Supplier A']);
    Supplier::factory()->create(['name' => 'Another Company']);

    $response = $this->getJson('/api/suppliers?name=Supplier A');

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
    $response->assertJsonFragment(['name' => 'Supplier A']);
    $response->assertJsonMissing(['name' => 'Another Company']);
});

it('should filter suppliers by document type', function () {
    Supplier::factory()->create(['document_type' => 'CPF', 'document_number' => '12345678901']);
    Supplier::factory()->create(['document_type' => 'CNPJ', 'document_number' => '33406775000109']);

    $response = $this->getJson('/api/suppliers?document_type=CPF');

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
    $response->assertJsonFragment(['document_type' => 'CPF']);
});

it('should fetch CNPJ data from external API', function () {
    $cnpj = '23811568000198';

    $response = $this->getJson("/api/suppliers/fetch-cnpj/$cnpj");

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'cnpj',
        'razao_social',
        'nome_fantasia',
        'logradouro',
        'porte',
    ]);
});
