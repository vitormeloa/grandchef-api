<?php

use App\Models\Product;
use function Pest\Laravel\{ postJson, assertDatabaseHas };

it('should be able to create an order', function () {
    $product = Product::factory()->create(['price' => 10.50]);

    $orderData = [
        'products' => [
            ['product_id' => $product->id, 'quantity' => 2]
        ]
    ];

    $response = postJson(route('orders.store'), $orderData)->assertCreated();

    assertDatabaseHas('orders', ['total_price' => 21.00]);

    $response->assertJson([
        'data' => [
            'total_price' => 21.00
        ]
    ]);
});

describe('validation rules for creating order', function () {
    test('products are required when creating an order', function () {
        postJson(route('orders.store'), [])->assertJsonValidationErrors(['products']);
    });
});
