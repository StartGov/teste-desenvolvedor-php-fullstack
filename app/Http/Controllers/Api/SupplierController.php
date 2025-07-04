<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Interfaces\SupplierRepositoryInterface;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\SupplierResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Suppliers",
 *     description="Endpoints for managing suppliers"
 * )
 */
class SupplierController extends Controller
{
    public function __construct(
        protected SupplierRepositoryInterface $supplierRepository
    ) {}

    /**
     * @OA\Get(
     *     path="/api/suppliers",
     *     summary="List all suppliers",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by company name or document number",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of suppliers",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Supplier"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $data = $this->supplierRepository->all($request);
        return SupplierResource::collection($data);
    }

    /**
     * @OA\Post(
     *     path="/api/suppliers",
     *     summary="Create a new supplier",
     *     tags={"Suppliers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Supplier")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Supplier created successfully"
     *     ),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function store(StoreSupplierRequest $request): JsonResponse
    {
        try {
            $supplier = $this->supplierRepository->create($request->validated());
            return response()->json([
                'message' => 'Supplier created successfully.',
                'data' => new SupplierResource($supplier)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating supplier.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/suppliers/{id}",
     *     summary="Get a single supplier",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the supplier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplier data",
     *         @OA\JsonContent(ref="#/components/schemas/Supplier")
     *     ),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function show(Supplier $supplier)
    {
        return new SupplierResource($supplier);
    }

    /**
     * @OA\Put(
     *     path="/api/suppliers/{id}",
     *     summary="Update a supplier",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Supplier ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Supplier")
     *     ),
     *     @OA\Response(response=200, description="Supplier updated"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier): JsonResponse
    {
        try {
            $updated = $this->supplierRepository->update($supplier, $request->validated());

            return response()->json([
                'message' => 'Supplier updated successfully.',
                'data' => new SupplierResource($updated)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating supplier.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/suppliers/{id}",
     *     summary="Delete a supplier",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Supplier ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Deleted successfully"),
     *     @OA\Response(response=500, description="Error deleting supplier")
     * )
     */
    public function destroy(Supplier $supplier): Response|JsonResponse
    {
        try {
            $this->supplierRepository->delete($supplier);
            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting supplier.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/suppliers/fetch-cnpj/{cnpj}",
     *     summary="Fetch supplier data from BrasilAPI by CNPJ",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="cnpj",
     *         in="path",
     *         required=true,
     *         description="CNPJ number (only digits)",
     *         @OA\Schema(type="string", pattern="\d{14}")
     *     ),
     *     @OA\Response(response=200, description="CNPJ found"),
     *     @OA\Response(response=404, description="CNPJ not found"),
     *     @OA\Response(response=422, description="Invalid CNPJ format")
     * )
     */
    public function fetchCNPJ($cnpj)
    {
        if (!preg_match('/^\d{14}$/', $cnpj)) {
            return response()->json(['error' => 'Invalid CNPJ format'], 422);
        }

        $response = Http::get("https://brasilapi.com.br/api/cnpj/v1/$cnpj");

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'CNPJ not found'], 404);
    }
}
