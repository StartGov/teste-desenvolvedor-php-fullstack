<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ServicesController extends Controller
{

    private string $baseUrl;
    public function __construct()
    {
        $this->baseUrl = 'https://brasilapi.com.br/api/cnpj/v1/';
    }

    public function __invoke(string $cnpj): response
    {
        $response = Http::get($this->baseUrl . $cnpj);

        $bodyResponse = json_decode($response->body());

        if ($response->status() === Response::HTTP_BAD_REQUEST) {
            return response([$bodyResponse], Response::HTTP_BAD_REQUEST);
        }

        return response([$bodyResponse], Response::HTTP_OK);
    }
}
