<?php

use App\Models\Product;
use App\Models\Category;
use function Pest\Laravel\getJson;

it('should show a specific product', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $category->id]);

    $response = getJson(route('products.show', $product->id))->assertOk();

    $response->assertJson([
        'data' => [
            'id'         => $product->id,
            'name'       => $product->name,
            'price'      => $product->price,
            'category_id'=> $product->category_id,
        ]
    ]);
});

test('should return a 404 if the product is not found', function () {
    getJson(route('products.show', 999))->assertNotFound();
});
