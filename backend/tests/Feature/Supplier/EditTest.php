<?php


use App\Models\Supplier;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\putJson;

it('should be able to update a supplier', function () {

    $supplier = Supplier::factory()->create();

    putJson(route('suppliers.update', $supplier), [
        'nome_fantasia' => 'Updating Nome',
    ])->assertOk();

    assertDatabaseHas('suppliers', [
        'cpf_cnpj' => $supplier->cpf_cnpj,
        'nome_fantasia' => 'Updating Nome',
        'razao_social' => $supplier->razao_social,
        'contato' => $supplier->contato,
        'endereco' => $supplier->endereco,
        'numero' => $supplier->numero,
    ]);
});
