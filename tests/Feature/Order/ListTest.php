<?php

use App\Models\Order;
use function Pest\Laravel\getJson;

it('should list all orders', function () {
    Order::factory()->count(3)->create();

    $response = getJson(route('orders.index'))->assertOk();

    $response->assertJsonCount(3, 'data.data');
});

test('should return an empty list if no orders exist', function () {
    $response = getJson(route('orders.index'))->assertOk();

    $response->assertJsonCount(0, 'data.data');
});
