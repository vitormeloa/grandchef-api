<?php

use App\Models\Product;
use App\Models\Category;
use function Pest\Laravel\putJson;

it('should update a product', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $category->id]);

    $updatedData = [
        'name' => 'Produto Atualizado',
        'price' => 10.50,
        'category_id' => $category->id,
    ];

    $response = putJson(route('products.update', $product->id), $updatedData)->assertOk();

    $response->assertJson([
        'data' => [
            'id'         => $product->id,
            'name'       => 'Produto Atualizado',
            'price'      => 10.50,
            'category_id'=> $category->id,
        ]
    ]);
});

describe('validation rules for updating product', function () {
    test('price should be a positive number when updating', function () {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        putJson(route('products.update', $product->id), [
            'name' => 'Produto Válido',
            'price' => -10,
            'category_id' => $category->id,
        ])->assertJsonValidationErrors(['price']);
    });
});
