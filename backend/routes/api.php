<?php


use App\Http\Controllers\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// region Suppliers

Route::post('suppliers', Supplier\StoreController::class)->name('suppliers.store');

// endregion



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
