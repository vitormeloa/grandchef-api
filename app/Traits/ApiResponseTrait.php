<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Retorna uma resposta de sucesso em Json.
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(mixed $data, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Retorna uma resposta de erro em Json.
     *
     * @param string $message
     * @param int $code
     * @param mixed|null $errors
     * @return JsonResponse
     */
    public function errorResponse(string $message, int $code = 400, mixed $errors = null): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
