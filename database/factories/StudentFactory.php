<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Student;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'firstName'=>$faker->firstName,
        'middleName'=>$faker->firstName,
        'surname'=>$faker->lastName,
        'lastName'=>$faker->lastName,
        'idNumber'=>$faker->integer,
        'email'=>$faker->unique()->safeEmail,
        'password'=>Hash::make('password'),
        'regNumber'=>$faker->text,

    ];
});
