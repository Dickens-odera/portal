<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Admins;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(Admins::class, function (Faker $faker) {
    return [
        'name'=>$faker->safeEmail()->unique(),
        'password'=>Hash::make('admin')
    ];
});
