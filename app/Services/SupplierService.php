<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SupplierService
{
    public static function index($supplier)
    {
        return response()->json($supplier->paginate(10));
    }

    public static function store($request)
    {
        try {
            DB::beginTransaction();
            if($request->document_type == 'CNPJ'){
                $response = SupplierService::verifyDocument($request->document_number);
                if($response == 'Exist'){
                    $supplier = new Supplier();
                    $supplier->fill($request->toArray());
                    if($supplier->save()){
                        DB::commit();
                    }
                    return Controller::mensager(Controller::SUCCESS, $supplier);
                }else{
                    return Controller::mensager(Controller::ERROR, "Non-existent company");
                }
            }else{
                $supplier = new Supplier();
                $supplier->fill($request->toArray());
                if($supplier->save()){
                    DB::commit();
                }
                return Controller::mensager(Controller::SUCCESS, $supplier);
            }

        }catch (\Exception $e){
            DB::rollBack();
            return Controller::mensager(Controller::ERROR, $e->getMessage());
        }
    }

    public static function show($id)
    {
        try {
            $supplier = Supplier::query()->findOrFail($id);
            return Controller::mensager(Controller::SUCCESS, $supplier);
        }catch (\Exception $e){
            return Controller::mensager(Controller::ERROR, $e->getMessage());
        }
    }

    public static function update($request, $id)
    {
        try {
            DB::beginTransaction();
            $supplier = Supplier::query()->findOrFail($id);
            $supplier->fill($request->toArray());
            if($supplier->save()){
                DB::commit();
                return Controller::mensager(Controller::SUCCESS, $supplier);
            }
        }catch (\Exception $e){
            DB::rollBack();
            return Controller::mensager(Controller::ERROR, $e->getMessage());
        }
    }

    public static function destroy($id)
    {
        try {
            $supplier = Supplier::query()->findOrFail($id);
            $dates = $supplier;
            if($supplier->forceDelete()){
                return Controller::mensager(Controller::SUCCESS, $dates);
            }
        }catch (\Exception $e){
            return Controller::mensager(Controller::ERROR, $e->getMessage());
        }

    }

    public static function verifyDocument($document)
    {
        try {
            $urlBrasil = 'https://brasilapi.com.br/api/cnpj/v1/';
            $response = Http::get($urlBrasil . $document);
            if($response->successful()) {
                return 'Exist';
            }else{
                return 'No Exist';
            }
        }catch (\Exception $e){
            return Controller::mensager(Controller::ERROR, $e->getMessage());
        }

    }

    public static function verifyCNPJ($document)
    {
        try {
            $urlBrasil = 'https://brasilapi.com.br/api/cnpj/v1/';
            $response = Http::get($urlBrasil . $document);
            if($response->successful()) {
                return $response->json();
            }else{
                return 'No Exist';
            }
        }catch (\Exception $e){
            return Controller::mensager(Controller::ERROR, $e->getMessage());
        }

    }
}