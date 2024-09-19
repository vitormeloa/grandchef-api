<?php

use App\Models\Category;
use function Pest\Laravel\{ postJson, assertDatabaseHas };

it('should be able to create a new category', function () {
    $categoryData = ['name' => 'Bebidas'];
    $response = postJson(route('categories.store'), $categoryData)->assertCreated();

    assertDatabaseHas('categories', ['name' => 'Bebidas']);

    $response->assertJson([
        'data' => [
            'name' => 'Bebidas'
        ]
    ]);
});

describe('validation rules for creating category', function () {
    test('name is required when creating a category', function () {
        postJson(route('categories.store'), [])->assertJsonValidationErrors(['name']);
    });

    test('name must be unique when creating a category', function () {
        $category = Category::factory()->create();
        postJson(route('categories.store'), ['name' => $category->name])->assertJsonValidationErrors(['name']);
    });
});
