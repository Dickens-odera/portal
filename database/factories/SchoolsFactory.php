<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Schools;
use Faker\Generator as Faker;

$factory->define(Schools::class, function (Faker $faker) {
    return [
        'school_name'=>$faker->name
    ];
});
