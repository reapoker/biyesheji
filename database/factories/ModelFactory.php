<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Model\Yundongyuan::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'sex' => "男",
        'zubie'=>'小学男子甲组-少年拳',
        'danwei'=>'青岛大学',
        'photo'=>'1521459848LCRmjiGV.png',
    ];
});
