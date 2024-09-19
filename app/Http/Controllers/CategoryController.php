<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    protected CategoryService $categoryService;

    /**
     * CategoryController constructor.
     *
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Retorna uma lista de todas as categorias.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();
        return $this->successResponse($categories, 'Categorias listadas com sucesso', ResponseAlias::HTTP_OK);
    }

    /**
     * Cria uma nova categoria com os dados fornecidos.
     *
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        try {
            $category = $this->categoryService->createCategory($request->validated());
            return $this->successResponse($category, 'Categoria criada com sucesso', ResponseAlias::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retorna uma categoria específica.
     *
     * @param $categoryId
     * @return JsonResponse
     */
    public function show($categoryId): JsonResponse
    {
        try {
            $category = $this->categoryService->getCategoryById($categoryId);
            return $this->successResponse($category, 'Categoria encontrada com sucesso', ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * Atualiza uma categoria com os dados fornecidos.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        try {
            $updatedCategory = $this->categoryService->updateCategory($category, $request->validated());
            return $this->successResponse($updatedCategory, 'Categoria atualizada com sucesso', ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deleta uma categoria.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        try {
            $this->categoryService->deleteCategory($category);
            return $this->successResponse(null, 'Categoria excluída com sucesso', ResponseAlias::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
