<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductService
{
    /**
     * Retorna uma lista paginada de produtos, incluindo a categoria associada.
     *
     * @return LengthAwarePaginator
     */
    public function getAllProducts(): LengthAwarePaginator
    {
        return Product::with('category')->paginate(10);
    }

    /**
     * Retorna um produto específico, incluindo a categoria associada.
     *
     * @param $productId
     * @return Product
     * @throws Exception
     */
    public function getProductById($productId): Product
    {
        try {
            return Product::with('category')->findOrFail($productId);
        } catch (Exception $e) {
            Log::error('Produto não encontrado: ID ' . $productId);
            throw new Exception('Produto não encontrado: ID ' . $productId);
        }
    }

    /**
     * Retorna um produto específico, incluindo a categoria associada.
     *
     *
     * @param array $data
     * @return Product
     * @throws Exception
     */
    public function createProduct(array $data): Product
    {
        try {
            return Product::create($data);
        } catch (Exception $e) {
            Log::error('Erro ao criar produto: ' . $e->getMessage());
            throw new Exception('Não foi possível criar o produto.');
        }
    }

    /**
     * Atualiza um produto com os dados fornecidos.
     *
     * @param Product $product
     * @param array $data
     * @return Product
     * @throws Exception
     */
    public function updateProduct(Product $product, array $data): Product
    {
        try {
            $product->update($data);
            return $product;
        } catch (Exception $e) {
            Log::error('Erro ao atualizar produto: ' . $e->getMessage());
            throw new Exception('Não foi possível atualizar o produto.');
        }
    }

    /**
     * Deleta um produto.
     *
     * @param Product $product
     * @return void
     * @throws Exception
     */
    public function deleteProduct(Product $product): void
    {
        try {
            $product->delete();
        } catch (Exception $e) {
            Log::error('Erro ao deletar produto: ' . $e->getMessage());
            throw new Exception('Não foi possível deletar o produto.');
        }
    }
}
