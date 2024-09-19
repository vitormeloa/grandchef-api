<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\OrderService;
use App\Models\Order;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrderController extends Controller
{
    use ApiResponseTrait;
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Retorna uma lista paginada de pedidos, incluindo os produtos associados.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = $this->orderService->getAllOrders();
        return $this->successResponse($orders, 'Pedidos listados com sucesso', ResponseAlias::HTTP_OK);
    }

    /**
     * Cria um novo pedido com os produtos fornecidos.
     *
     * @param StoreOrderRequest $request
     * @return JsonResponse
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrder($request->validated()['products']);
            return $this->successResponse($order, 'Pedido criado com sucesso', ResponseAlias::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retorna um pedido específico, incluindo os produtos associados.
     *
     * @param $orderId
     * @return JsonResponse
     */
    public function show($orderId): JsonResponse
    {
        try {
            $order = $this->orderService->getOrderById($orderId);
            return $this->successResponse($order, 'Pedido encontrado com sucesso', ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * Atualiza um pedido com os dados fornecidos.
     *
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        try {
            $updatedOrder = $this->orderService->updateOrder($order, $request->validated());
            return $this->successResponse($updatedOrder, 'Pedido atualizado com sucesso', ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deleta um pedido.
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function destroy(Order $order): JsonResponse
    {
        try {
            $this->orderService->deleteOrder($order);
            return $this->successResponse(null, 'Pedido excluído com sucesso', ResponseAlias::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
