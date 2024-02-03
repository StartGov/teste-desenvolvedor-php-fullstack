<?php


use App\Models\Supplier;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('should be able to store a new supplier', function () {

    postJson(route('suppliers.store', [
        'cpf_cnpj' => '19131243000197',
        'nome_fantasia' => 'Empresa Teste',
        'razao_social' => 'Empresa Teste',
        'contato' => '99999999999',
        'endereco' => 'FRANCA',
        'numero' => '144',
    ]))->assertSuccessful();

    assertDatabaseHas('suppliers', [
        'cpf_cnpj' => '19131243000197',
        'nome_fantasia' => 'Empresa Teste',
        'razao_social' => 'Empresa Teste',
        'contato' => '99999999999',
        'endereco' => 'FRANCA',
        'numero' => '144',
    ]);
});

describe('validation rules', function () {

    test('supplier::cpf_cnpj required', function () {
        postJson(route('suppliers.store', []))
            ->assertJsonValidationErrors([
                'cpf_cnpj' => 'required',
            ]);
    });

    test('supplier::cpf_cnpj characters should be min 11', function () {

        postJson(route('suppliers.store', [
            'cpf_cnpj' => '1111111111',
        ]))
            ->assertJsonValidationErrors([
                'cpf_cnpj' => 'least 11 characters',
            ]);
    });

    test('supplier::cpf_cnpj characters should be max 14', function () {

        postJson(route('suppliers.store', [
            'cpf_cnpj' => '111111111111111',
        ]))
            ->assertJsonValidationErrors([
                'cpf_cnpj' => 'must not be greater than 14 characters.',
            ]);
    });

    test('supplier::cpf_cnpj should be unique', function () {

        Supplier::factory()->create([
            'cpf_cnpj' => '19131243000197'
        ]);
        postJson(route('suppliers.store', [
            'cpf_cnpj' => '19131243000197',
        ]))
            ->assertJsonValidationErrors([
                'cpf_cnpj' => 'already been taken',
            ]);
    });

    test('supplier::nome_fantasia required', function () {
        postJson(route('suppliers.store', []))
            ->assertJsonValidationErrors([
                'nome_fantasia' => 'required',
            ]);
    });

    test('supplier::razao_social required', function () {
        postJson(route('suppliers.store', []))
            ->assertJsonValidationErrors([
                'razao_social' => 'required',
            ]);
    });
});
