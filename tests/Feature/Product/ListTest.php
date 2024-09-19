<?php

use App\Models\Product;
use App\Models\Category;
use function Pest\Laravel\getJson;

it('should list all products', function () {
    $category = Category::factory()->create();
    Product::factory()->count(3)->create(['category_id' => $category->id]);

    $response = getJson(route('products.index'))->assertOk();

    $response->assertJsonCount(3, 'data.data');
});

test('should return an empty list if no products exist', function () {
    $response = getJson(route('products.index'))->assertOk();

    $response->assertJsonCount(0, 'data.data');
});
