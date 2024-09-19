<?php

use App\Models\Category;
use function Pest\Laravel\{ deleteJson, assertDatabaseMissing };

it('should delete a category', function () {
    $category = Category::factory()->create();

    deleteJson(route('categories.destroy', $category->id))->assertNoContent();

    assertDatabaseMissing('categories', ['id' => $category->id]);
});

test('should return a 404 if trying to delete a non-existent category', function () {
    deleteJson(route('categories.destroy', 999))->assertNotFound();
});
