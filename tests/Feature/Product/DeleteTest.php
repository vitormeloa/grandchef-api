<?php

use App\Models\Product;
use App\Models\Category;
use function Pest\Laravel\deleteJson;

it('should delete a product', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $category->id]);

    deleteJson(route('products.destroy', $product->id))->assertNoContent();

    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});

test('should return a 404 if trying to delete a non-existent product', function () {
    deleteJson(route('products.destroy', 999))->assertNotFound();
});
