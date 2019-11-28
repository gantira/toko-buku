<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'author' => 'author',
        'publisher' => 'publisher',
        'isbn' => rand(0, 999999999999),
        'year' => 2000,
        'price' => rand(10000, 99999),
        'stock' => rand(1, 10),
        'curriculum' => $faker->title,
        'image' => null,
    ];
});
