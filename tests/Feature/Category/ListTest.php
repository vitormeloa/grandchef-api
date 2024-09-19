<?php

use App\Models\Category;
use function Pest\Laravel\getJson;

it('should list all categories', function () {
    Category::factory()->count(3)->create();

    $response = getJson(route('categories.index'))->assertOk();

    $response->assertJsonCount(3, 'data');
});

test('should return an empty list if no categories exist', function () {
    $response = getJson(route('categories.index'))->assertOk();

    $response->assertJsonCount(0, 'data');
});
