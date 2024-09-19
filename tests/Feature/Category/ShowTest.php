<?php

use App\Models\Category;
use function Pest\Laravel\getJson;

it('should show a specific category', function () {
    $category = Category::factory()->create();

    $response = getJson(route('categories.show', $category->id))->assertOk();

    $response->assertJson([
        'data' => [
            'id' => $category->id,
            'name' => $category->name
        ]
    ]);
});

test('should return a 404 if the category is not found', function () {
    getJson(route('categories.show', 999))->assertNotFound();
});
