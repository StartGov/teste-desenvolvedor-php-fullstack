<?php


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
});
