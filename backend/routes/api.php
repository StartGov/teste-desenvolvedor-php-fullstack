<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/test', function(){
    return [
        [
            'age' => 20,
            'first_name' => 'Josivan',
            'last_name' => 'Sousa'
        ],
        [
            'age' => 39,
            'first_name' => 'João',
            'last_name' => 'Vitor'
        ],
        [
            'age' => 13,
            'first_name' => 'Vitor',
            'last_name' => 'Emanoel'
        ],
        [
            'age' => 54,
            'first_name' => 'Mateus',
            'last_name' => 'Carvalho'
        ],
        [
            'age' => 13,
            'first_name' => 'Breno',
            'last_name' => 'Lope'
        ],
        [
            'age' => 13,
            'first_name' => 'Vinicius',
            'last_name' => 'Jr'
        ],
        [
            'age' => 13,
            'first_name' => 'Leo',
            'last_name' => 'Messi'
        ],

    ];
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
