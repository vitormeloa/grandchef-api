<?php

use App\Models\Category;
use function Pest\Laravel\{ putJson, assertDatabaseHas };

it('should update a category', function () {
    $category = Category::factory()->create();

    $updatedData = ['name' => 'Doces'];
    putJson(route('categories.update', $category->id), $updatedData)->assertOk();

    assertDatabaseHas('categories', ['name' => 'Doces']);
});

describe('validation rules for updating category', function () {
    test('name is required when updating a category', function () {
        $category = Category::factory()->create();
        putJson(route('categories.update', $category->id), ['name' => ''])->assertJsonValidationErrors(['name']);
    });

    test('name must be unique when updating a category', function () {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        putJson(route('categories.update', $category2->id), ['name' => $category1->name])->assertJsonValidationErrors(['name']);
    });
});
