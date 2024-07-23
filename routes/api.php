<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/supplier', [SupplierController::class, 'index']);
Route::post('/supplier', [SupplierController::class, 'store']);
Route::get('/supplier/{id}', [SupplierController::class, 'show']);
Route::put('/supplier/{id}', [SupplierController::class, 'update']);
Route::delete('/supplier/{id}', [SupplierController::class, 'destroy']);
Route::get('/supplier-cnpj/{cnpj}', [SupplierController::class, 'consultCnpj']);


