<?php

use App\Models\Supplier;
use function Pest\Laravel\getJson;

it('should be able to list suppliers', function () {

    Supplier::factory(50)->create();

    $response = getJson(route('suppliers.index'))->assertSuccessful();

    $response->assertJsonCount(50, 'data');
});
