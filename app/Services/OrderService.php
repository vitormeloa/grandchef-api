<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class OrderService
{
    /**
     * Retorna uma lista paginada de pedidos, incluindo os produtos associados.
     *
     * @return LengthAwarePaginator
     */
    public function getAllOrders(): LengthAwarePaginator
    {
        return Order::with('products')->paginate(10);
    }

    /**
     * Retorna um pedido específico, incluindo os produtos associados.
     *
     * @param $orderId
     * @return Order
     * @throws Exception
     */
    public function getOrderById($orderId): Order
    {
        try {
            return Order::with('products')->findOrFail($orderId);
        } catch (Exception $e) {
            Log::error('Pedido não encontrado: ID ' . $orderId);
            throw new Exception('Pedido não encontrado: ID ' . $orderId);
        }
    }

    /**
     * Cria um novo pedido com os produtos fornecidos.
     *
     * @param array $products
     * @return Order
     * @throws Exception
     */
    public function createOrder(array $products): Order
    {
        try {
            return DB::transaction(function () use ($products) {
                $order = Order::create();
                $totalPrice = $this->calculateTotalPrice($order, $products);
                $order->update(['total_price' => $totalPrice]);

                return $order->load('products');
            });
        } catch (Exception $e) {
            Log::error('Erro ao criar pedido: ' . $e->getMessage());
            throw new Exception('Erro ao processar o pedido. Tente novamente mais tarde.');
        }
    }

    /**
     * Atualiza um pedido com os dados fornecidos.
     *
     * @param Order $order
     * @param array $data
     * @return Order
     * @throws Exception
     */
    public function updateOrder(Order $order, array $data): Order
    {
        return DB::transaction(function () use ($order, $data) {
            if (isset($data['products'])) {
                $this->updateProductsAtOrder($order, $data['products']);
            }

            $order->update([
                'status' => $data['status'] ?? $order->status,
            ]);

            return $order->load('products');
        });
    }

    /**
     * Atualiza os produtos associados a um pedido.
     *
     * @param Order $order
     * @param array $products
     * @return void
     * @throws Exception
     */
    private function updateProductsAtOrder(Order $order, array $products): void
    {
        $order->products()->detach();
        $totalPrice = $this->calculateTotalPrice($order, $products);
        $order->update(['total_price' => $totalPrice]);
    }


    /**
     * Deleta um pedido.
     *
     * @param Order $order
     * @return void
     * @throws Exception
     */
    public function deleteOrder(Order $order): void
    {
        try {
            $order->delete();
        } catch (Exception $e) {
            Log::error('Erro ao deletar pedido: ' . $e->getMessage());
            throw new Exception('Erro ao deletar o pedido.');
        }
    }

    /**
     * Calcula o preço total do pedido e associa os produtos ao pedido.
     *
     * @param Order $order
     * @param array $products
     * @return float
     * @throws Exception
     */
    private function calculateTotalPrice(Order $order, array $products): float
    {
        $totalPrice = 0;

        foreach ($products as $productData) {
            $product = $this->findProduct($productData['product_id']);
            $totalPrice += $this->attachProductToOrder($order, $product, $productData['quantity']);
        }

        return $totalPrice;
    }

    /**
     * Busca o produto pelo ID. Lança uma exceção se o produto não for encontrado.
     *
     * @param int $productId
     * @return Product
     * @throws Exception
     */
    private function findProduct(int $productId): Product
    {
        try {
            return Product::findOrFail($productId);
        } catch (Exception $e) {
            Log::error('Produto não encontrado: ID ' . $productId);
            throw new Exception('Produto não encontrado: ID ' . $productId);
        }
    }

    /**
     * Associa um produto ao pedido e retorna o valor total para aquele produto.
     *
     * @param Order $order
     * @param Product $product
     * @param int $quantity
     * @return float
     */
    private function attachProductToOrder(Order $order, Product $product, int $quantity): float
    {
        $price = $product->price;
        $order->products()->attach($product->id, [
            'price' => $price,
            'quantity' => $quantity,
        ]);

        return $price * $quantity;
    }
}
