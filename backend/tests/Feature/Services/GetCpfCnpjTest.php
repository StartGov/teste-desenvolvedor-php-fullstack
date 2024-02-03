<?php

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

it('should be able to get data of supplier by valid cnpj', function () {
    $cnpj = '19131243000197';

    Http::fake([
        'https://brasilapi.com.br/api/cnpj/v1/*' => Http::response('{
            "uf": "SP",
            "cep": "01311902",
            "cnpj": "19131243000197"
        }', Response::HTTP_OK),
    ]);

    $response = $this->get(route('suppliers.services', $cnpj));
    $response->assertStatus(Response::HTTP_OK)
        ->assertJson([
            [
                'uf' => 'SP',
                'cep' => '01311902',
                'cnpj' => '19131243000197',
            ]
        ]);
});
