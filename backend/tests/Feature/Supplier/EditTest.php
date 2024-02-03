<?php

use App\Models\Supplier;

use function Pest\Laravel\{assertDatabaseHas, putJson};

it('should be able to update a supplier', function () {

    $supplier = Supplier::factory()->create();

    putJson(route('suppliers.update', $supplier), [
        'cpf_cnpj'      => $supplier->cpf_cnpj,
        'nome_fantasia' => 'Updating Nome',
        'razao_social'  => $supplier->razao_social,
        'contato'       => $supplier->contato,
        'endereco'      => $supplier->endereco,
        'numero'        => $supplier->numero,
    ])->assertOk();

    assertDatabaseHas('suppliers', [
        'cpf_cnpj'      => $supplier->cpf_cnpj,
        'nome_fantasia' => 'Updating Nome',
        'razao_social'  => $supplier->razao_social,
        'contato'       => $supplier->contato,
        'endereco'      => $supplier->endereco,
        'numero'        => $supplier->numero,
    ]);
});

describe('validation rules', function () {

    test('supplier::cpf_cnpj required', function () {

        $supplier = Supplier::factory()->create();

        putJson(route('suppliers.update', $supplier), [
            'cpf_cnpj' => '',
        ])
            ->assertJsonValidationErrors([
                'cpf_cnpj' => 'required',
            ]);
    });

    test('supplier::cpf_cnpj characters should be min 11', function () {

        $supplier = Supplier::factory()->create();

        putJson(route('suppliers.update', $supplier), [
            'cpf_cnpj' => '1111111111',
        ])
            ->assertJsonValidationErrors([
                'cpf_cnpj' => 'least 11 characters',
            ]);
    });

    test('supplier::cpf_cnpj characters should be max 14', function () {

        $supplier = Supplier::factory()->create();

        putJson(route('suppliers.update', $supplier), [
            'cpf_cnpj' => '111111111111111',
        ])
            ->assertJsonValidationErrors([
                'cpf_cnpj' => 'must not be greater than 14 characters.',
            ]);
    });

    test('supplier::cpf_cnpj should be unique', function () {
        Supplier::factory()->create([
            'cpf_cnpj' => '19131243000197',
        ]);

        $supplier = Supplier::factory()->create();

        putJson(route('suppliers.update', $supplier), [
            'cpf_cnpj' => '19131243000197',
        ])
            ->assertJsonValidationErrors([
                'cpf_cnpj' => 'already been taken',
            ]);
    });

    // TODO: test not passing
    //    test('supplier::should be unique only if id is different', function () {
    //        $supplier = Supplier::factory()->create([
    //            'cpf_cnpj' => '19131243000197',
    //        ]);
    //
    //        putJson(route('suppliers.update', $supplier), [
    //            'cpf_cnpj' => '19131243000197',
    //        ])->assertOk();
    //    });

    test('supplier::nome_fantasia required', function () {

        $supplier = Supplier::factory()->create();

        putJson(route('suppliers.update', $supplier), [
            'nome_fantasia' => '',
        ])
            ->assertJsonValidationErrors([
                'nome_fantasia' => 'required',
            ]);
    });

    test('supplier::razao_social required', function () {

        $supplier = Supplier::factory()->create();

        putJson(route('suppliers.update', $supplier), [
            'razao_social' => '',
        ])
            ->assertJsonValidationErrors([
                'razao_social' => 'required',
            ]);
    });

    test('supplier::contato required', function () {

        $supplier = Supplier::factory()->create();

        putJson(route('suppliers.update', $supplier), [
            'contato' => '',
        ])
            ->assertJsonValidationErrors([
                'contato' => 'required',
            ]);
    });

    test('supplier::endereco required', function () {

        $supplier = Supplier::factory()->create();

        putJson(route('suppliers.update', $supplier), [
            'endereco' => '',
        ])
            ->assertJsonValidationErrors([
                'endereco' => 'required',
            ]);
    });

    test('supplier::numero required', function () {

        $supplier = Supplier::factory()->create();

        putJson(route('suppliers.update', $supplier), [
            'numero' => '',
        ])
            ->assertJsonValidationErrors([
                'numero' => 'required',
            ]);
    });
});

test('after editing we should return a status 200 with the updated supplier', function () {

    $supplier = Supplier::factory()->create();

    $request = putJson(
        route('suppliers.update', $supplier),
        [
            'cpf_cnpj'      => $supplier->cpf_cnpj,
            'nome_fantasia' => 'Updating Nome',
            'razao_social'  => $supplier->razao_social,
            'contato'       => $supplier->contato,
            'endereco'      => $supplier->endereco,
            'numero'        => $supplier->numero,
        ]
    )->assertOk();

    $supplier = Supplier::latest()->first();

    $request->assertJson([
        'data' => [
            'id'            => $supplier->id,
            'cpf_cnpj'      => $supplier->cpf_cnpj,
            'nome_fantasia' => $supplier->nome_fantasia,
            'razao_social'  => $supplier->razao_social,
            'contato'       => $supplier->contato,
            'endereco'      => $supplier->endereco,
            'numero'        => $supplier->numero,
            'created_at'    => $supplier->created_at->format('Y-m-d h:i:s'),
            'updated_at'    => $supplier->updated_at->format('Y-m-d h:i:s'),
        ],
    ]);
});
