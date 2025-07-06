<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'suppliers'], function () {
    Route::get('/', [\App\Http\Controllers\SupplierController::class, 'index']);
    Route::get('/document', [\App\Http\Controllers\SupplierController::class, 'showByDocument']);
    Route::get('/{id}', [\App\Http\Controllers\SupplierController::class, 'show']);
    Route::get('/fetch-cnpj/{cnpj}', [\App\Http\Controllers\SupplierController::class, 'fetchCpnj']);
    Route::post('/', [\App\Http\Controllers\SupplierController::class, 'store']);
    Route::patch('/{id}', [\App\Http\Controllers\SupplierController::class, 'update']);
    Route::delete('/{id}', [\App\Http\Controllers\SupplierController::class, 'destroy']);
});
