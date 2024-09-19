<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{
    use ApiResponseTrait;
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Retorna uma lista paginada de produtos, incluindo a categoria associada.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();

        return $this->successResponse($products, 'Produtos listados com sucesso', ResponseAlias::HTTP_OK);
    }

    /**
     * Cria um produto específico.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $product = $this->productService->createProduct($request->validated());
            return $this->successResponse($product, 'Produto criado com sucesso', ResponseAlias::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retorna um produto específico, incluindo a categoria associada.
     *
     * @param $productId
     * @return JsonResponse
     */
    public function show($productId): JsonResponse
    {
        try {
            $product = $this->productService->getProductById($productId);
            return $this->successResponse($product, 'Produto encontrado com sucesso', ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * Atualiza um produto com os dados fornecidos.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        try {
            $updatedProduct = $this->productService->updateProduct($product, $request->validated());
            return $this->successResponse($updatedProduct, 'Produto atualizado com sucesso', ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deleta um produto.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            $this->productService->deleteProduct($product);
            return $this->successResponse([], 'Produto excluído com sucesso', ResponseAlias::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
