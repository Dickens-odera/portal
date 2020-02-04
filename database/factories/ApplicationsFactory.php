<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Applications;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Applications::class, function (Faker $faker) {
    return [
        'student_name'=>$faker->name,
        'student_phone'=>$faker->phoneNumber,
        'reg_number'=>$faker->text($mxNbChars = 12)
    ];
});
