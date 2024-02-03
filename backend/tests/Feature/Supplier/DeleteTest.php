<?php

use App\Models\Supplier;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

it('should be able to delete a supplier', function () {

    $supplier = Supplier::factory()->create();

    deleteJson(route('suppliers.delete', $supplier))
        ->assertNoContent();

    assertDatabaseMissing('suppliers', ['id' => $supplier->id]);
});
