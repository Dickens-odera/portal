<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Deans;
use App\Schools;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(Deans::class, function (Faker $faker) {
    return [
        'email'=>$faker->unique()->safeEmail(),
        'name'=>$faker->name,
        'school_id'=> factory(Schools::class),
        'password'=>Hash::make('password')
    ];
});
