<?php


use App\Http\Controllers\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// region Suppliers

Route::get('/suppliers',Supplier\IndexController::class)->name('suppliers.index');
Route::post('suppliers', Supplier\StoreController::class)->name('suppliers.store');
Route::put('suppliers/{supplier}', Supplier\UpdateController::class)->name('suppliers.update');
Route::delete('suppliers/{supplier}', Supplier\DeleteController::class)->name('suppliers.delete');
// endregion



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
