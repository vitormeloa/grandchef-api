<?php

use App\Models\Order;
use function Pest\Laravel\getJson;

it('should show a specific order', function () {
    $order = Order::factory()->create();

    $response = getJson(route('orders.show', $order->id))->assertOk();

    $response->assertJson([
        'data' => [
            'id' => $order->id,
            'total_price' => $order->total_price
        ]
    ]);
});

test('should return a 404 if the order is not found', function () {
    getJson(route('orders.show', 999))->assertNotFound();
});
