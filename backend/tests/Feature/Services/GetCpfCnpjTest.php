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
                'uf'   => 'SP',
                'cep'  => '01311902',
                'cnpj' => '19131243000197',
            ],
        ]);
});

it('should be able to return 400 response for invalid cnpj', function () {
    $cnpj = '1111111111';

    Http::fake([
        'https://brasilapi.com.br/api/cnpj/v1/*' => Http::response('{
            "message": "CNPJ 1111111 inválido.",
            "type": "bad_request",
            "name": "BadRequestError"
        }', Response::HTTP_BAD_REQUEST),
    ]);

    $response = $this->get(route('suppliers.services', $cnpj));
    $response->assertStatus(Response::HTTP_BAD_REQUEST)
        ->assertJson([
            [
                'message' => 'CNPJ 1111111 inválido.',
                'type'    => 'bad_request',
                'name'    => 'BadRequestError',
            ],
        ]);
});
