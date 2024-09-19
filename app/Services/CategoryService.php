<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Exception;

class CategoryService
{
    /**
     * Retorna uma lista de todas as categorias.
     *
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    /**
     * Retorna uma categoria específica.
     *
     * @param $categoryId
     * @return Category
     * @throws Exception
     */
    public function getCategoryById($categoryId): Category
    {
        try {
            return Category::findOrFail($categoryId);
        } catch (Exception $e) {
            Log::error('Categoria não encontrada: ID ' . $categoryId);
            throw new Exception('Categoria não encontrada: ID ' . $categoryId);
        }
    }

    /**
     * Retorna uma categoria específica.
     *
     * @param array $data
     * @return Category
     * @throws Exception
     */
    public function createCategory(array $data): Category
    {
        try {
            return Category::create($data);
        } catch (Exception $e) {
            Log::error('Erro ao criar categoria: ' . $e->getMessage());
            throw new Exception('Não foi possível criar a categoria.');
        }
    }

    /**
     * Atualiza uma categoria com os dados fornecidos.
     *
     * @param Category $category
     * @param array $data
     * @return Category
     * @throws Exception
     */
    public function updateCategory(Category $category, array $data): Category
    {
        try {
            $category->update($data);
            return $category;
        } catch (Exception $e) {
            Log::error('Erro ao atualizar categoria: ' . $e->getMessage());
            throw new Exception('Não foi possível atualizar a categoria.');
        }
    }

    /**
     * Deleta uma categoria.
     *
     * @param Category $category
     * @return void
     * @throws Exception
     */
    public function deleteCategory(Category $category): void
    {
        try {
            $category->delete();
        } catch (Exception $e) {
            Log::error('Erro ao deletar categoria: ' . $e->getMessage());
            throw new Exception('Não foi possível deletar a categoria.');
        }
    }
}
