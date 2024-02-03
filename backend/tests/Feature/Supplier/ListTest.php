<?php

use App\Models\Supplier;

use function Pest\Laravel\getJson;

it('should be able to list suppliers', function () {

    Supplier::factory(15)->create();

    $response = getJson(route('suppliers.index'))->assertSuccessful();

    $response->assertJsonCount(15, 'data');
});

it('should be able to paginate list of suppliers', function () {

    Supplier::factory(50)->create();

    $response = getJson(route('suppliers.index'))->assertSuccessful();

    $response->assertJsonCount(15, 'data');

    $response->assertJson([
        'meta' => [
            'current_page' => 1,
            'per_page'     => 15,
            'total'        => 50,
        ],
    ]);
});
