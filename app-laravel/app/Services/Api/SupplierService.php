<?php

namespace App\Services\Api;

use App\DTOS\Api\SupplierDTO;
use App\Interfaces\Api\ISupplierRepository;
use App\Interfaces\Api\ISupplierService;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use stdClass;

class SupplierService implements ISupplierService {
    public function __construct(
        protected ISupplierRepository $repository,
        protected Client $httpClient,
    ) {}

    public function index() {
        $suppliers = $this->repository->index();
        
        return $suppliers;
    }

    public function store(SupplierDTO $data): stdClass {
        $cnpj = $this->sanitizeCNPJ($data->document_number);
        
        if($this->isCNPJ($cnpj)) {
            $this->validateCNPJ($cnpj);
        }

        $supplier = $this->repository->store($data);
        
        return $supplier;
    }
    
    public function show(string $id): stdClass | null {
        $this->validateSupplierExists($id);
        $supplier = $this->repository->show($id);
        
        return $supplier;
    }
    
    public function update(string $id, SupplierDTO $data): stdClass | null {
        $this->validateSupplierExists($id);
        
        $cnpj = $this->sanitizeCNPJ($data->document_number);
        
        if($this->isCNPJ($cnpj)) {
            $this->validateCNPJ($cnpj);
        }

        $supplier = $this->repository->update($id, $data);
        
        return $supplier;
    }

    public function destroy(string $id): void {
        $this->validateSupplierExists($id);
        $this->repository->destroy($id);
    }

    private function validateSupplierExists(string $id) {
        $supplier = $this->repository->findOne($id);
        
        if (!$supplier) throw new Exception('Fornecedor não encontrado.');
    }

    private function isCNPJ(string $document): bool {
        return strlen($document) === 14;
    }

    private function sanitizeCNPJ(string $cnpj): string {
        return preg_replace('/\D/', '', $cnpj);
    }

    private function validateCNPJ(string $cnpj) {    
        try {
            $response = $this->httpClient->request('GET', "https://brasilapi.com.br/api/cnpj/v1/$cnpj");  
        } catch (ClientException $error) {
            $response = $error->getResponse();
    
            if ($response->getStatusCode() === 404 || $response->getStatusCode() === 400) {
                throw new Exception("CNPJ Inválido, não foi possível localizar.");
            }
    
            throw new Exception('Erro ao validar CNPJ: ' . $error->getMessage());
        }
    }   
}