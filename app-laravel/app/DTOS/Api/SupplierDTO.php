<?php

namespace App\DTOS\Api;

use App\Http\Requests\SupplierRequest;

class SupplierDTO
{
    public function __construct(
        public string $document_number,
        public string $name_or_company,
        public string $contact,
        public string $address,
    ) {}
    
    public static function makeFromRequest(SupplierRequest $request): self {
        return new self(
            $request->document_number,
            $request->name_or_company,
            $request->contact,
            $request->address,
        );
    }
}