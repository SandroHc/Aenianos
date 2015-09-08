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

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\News::class, function ($faker) {
	return [
		'title' => $faker->sentence(),
		'text' => $faker->realText(),
		'id_category' => $faker->numberBetween(1, 2),
		'created_by' => $faker->numberBetween(1, 1),
		'updated_by' => $faker->numberBetween(1, 1),
	];
});

$factory->define(App\Models\Anime::class, function ($faker) {
	return [
		'title' => $faker->name,
		'synopsis' => $faker->text,
		'status' => $faker->randomElement([ 'Em lançamento', 'Em tradução', 'Concluído' ]),
	];
});

$factory->define(App\Models\Episode::class, function ($faker) {
	return [
		'anime_id' => $faker->numberBetween(1, 3),
		'num' => $faker->numberBetween(1, 20),
		'type' => $faker->randomElement([ 'episodio', 'filme', 'especial' ]),
	];
});

$factory->define(App\Models\Download::class, function ($faker) {
	return [
		'episode_id' => $faker->numberBetween(1, 30),
		'host_name' => $faker->randomElement([ 'MEGA', 'Google Drive' ]),
		'host_link' => $faker->randomElement([ 'http://mega.nz', 'https://drive.google.com/file/d/0B8KL1BNoXI0jblotVS1YQkE3TEE/view?usp=sharing' ]),
		'quality' => $faker->randomElement([ 'BD', 'HD', 'SD' ]),
		'size' => $faker->biasedNumberBetween(50, 500),
	];
});

