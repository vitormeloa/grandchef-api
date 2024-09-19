<?php

use App\Models\Order;
use App\Models\Product;
use function Pest\Laravel\{ putJson, assertDatabaseHas };

it('should update an order without recalculating total price if products are not changed', function () {
    $order = Order::factory()->create(['total_price' => 100.00]);

    $updatedData = [
        'status' => 'completed'
    ];

    $response = putJson(route('orders.update', $order->id), $updatedData)->assertOk();

    $response->assertJson([
        'data' => [
            'total_price' => "100.00"
        ]
    ]);

    assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'completed', 'total_price' => 100.00]);
});

it('should update an order and recalculate total price if products are changed', function () {
    $order = Order::factory()->create();
    $product = Product::factory()->create(['price' => 15.00]);

    $updatedData = [
        'status' => 'completed',
        'products' => [
            ['product_id' => $product->id, 'quantity' => 3]
        ]
    ];

    $response = putJson(route('orders.update', $order->id), $updatedData)->assertOk();

    $response->assertJson([
        'data' => [
            'total_price' => "45.00"
        ]
    ]);

    assertDatabaseHas('orders', ['id' => $order->id, 'total_price' => 45.00]);
});
