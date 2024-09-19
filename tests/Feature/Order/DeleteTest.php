<?php

use App\Models\Order;
use function Pest\Laravel\{ deleteJson, assertDatabaseMissing };

it('should delete an order', function () {
    $order = Order::factory()->create();

    deleteJson(route('orders.destroy', $order->id))->assertNoContent();

    assertDatabaseMissing('orders', ['id' => $order->id]);
});

test('should return a 404 if trying to delete a non-existent order', function () {
    deleteJson(route('orders.destroy', 999))->assertNotFound();
});
