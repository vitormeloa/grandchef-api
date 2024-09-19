<?php

use App\Models\Product;
use App\Models\Category;
use function Pest\Laravel\{assertDatabaseHas, postJson};

it('should be able to store a new product', function () {
    $category = Category::factory()->create();

    postJson(route('products.store'), [
        'name' => 'Refrigerante',
        'price' => 5.50,
        'category_id' => $category->id
    ])->assertSuccessful();

    assertDatabaseHas('products', [
        'name' => 'Refrigerante',
        'price' => 5.50,
        'category_id' => $category->id
    ]);
});

describe('validation rules for product creation', function () {

    test('name is required', function () {
        postJson(route('products.store'), [
            'name' => ''
        ])->assertJsonValidationErrors(['name']);
    });

    test('price is required', function () {
        postJson(route('products.store'), [
            'price' => ''
        ])->assertJsonValidationErrors(['price']);
    });

    test('category_id is required', function () {
        postJson(route('products.store'), [
            'category_id' => null
        ])->assertJsonValidationErrors(['category_id']);
    });

    test('price should be a positive number', function () {
        $category = Category::factory()->create();

        postJson(route('products.store'), [
            'name' => 'Produto Inválido',
            'price' => -5,
            'category_id' => $category->id
        ])->assertJsonValidationErrors(['price']);
    });

});

test('after creating, it should return a 201 status with the created product', function () {
    $category = Category::factory()->create();

    $response = postJson(route('products.store'), [
        'name' => 'Refrigerante',
        'price' => 5.50,
        'category_id' => $category->id
    ])->assertCreated();

    $product = Product::latest()->first();

    $response->assertJson([
        'data' => [
            'id'         => $product->id,
            'name'       => $product->name,
            'price'      => $product->price,
            'category_id'=> $product->category_id,
            'created_at' => $product->created_at->toJSON(),
            'updated_at' => $product->updated_at->toJSON(),
        ],
    ]);
});
