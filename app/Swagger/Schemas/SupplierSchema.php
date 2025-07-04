<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Supplier",
 *     type="object",
 *     required={"document_number", "company_name"},
 *     @OA\Property(property="document_number", type="string", example="12345678000195"),
 *     @OA\Property(property="company_name", type="string", example="Empresa Exemplo Ltda"),
 *     @OA\Property(property="email", type="string", example="empresa@exemplo.com"),
 *     @OA\Property(property="phone", type="string", example="(31) 99999-8888"),
 *     @OA\Property(property="zipcode", type="string", example="30130-000"),
 *     @OA\Property(property="address", type="string", example="Rua Exemplo"),
 *     @OA\Property(property="address_number", type="string", example="123"),
 *     @OA\Property(property="address_complement", type="string", example="sala 5"),
 *     @OA\Property(property="neighborhood", type="string", example="Centro"),
 *     @OA\Property(property="city", type="string", example="Belo Horizonte"),
 *     @OA\Property(property="state", type="string", example="MG"),
 * )
 */
class SupplierSchema {}
