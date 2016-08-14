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

$factory->define(App\User::class, function($faker) {
    return [
        'name' => $faker->userName,
        'email' => $faker->email,
        'password' => Hash::make($faker->password),
        'remember_token' => NULL,
        'admin' => false,
    ];
});

$factory->define(App\Models\News::class, function($faker) {
	return [
		'title' => $faker->sentence(),
		'text' => $faker->realText(),
		'id_category' => $faker->numberBetween(1, 2),
		'created_by' => $faker->numberBetween(1, 1),
		'updated_by' => $faker->numberBetween(1, 1),
	];
});

$factory->define(App\Models\Anime::class, function($faker) {
	$cover = $faker->imageUrl(350, 500);

	return [
		'title' => $faker->name,
		'synopsis' => $faker->text,
		'status' => $faker->randomElement([ 'Em lançamento', 'Em tradução', 'Concluído' ]),
		'cover' => $cover,
		'official_cover' => $cover,
	];
});

$factory->define(App\Models\Episode::class, function($faker) {
	static $unique_num = 1;

	return [
		'anime' => \App\Models\Anime::find($faker->numberBetween(1, 1))->slug,
		'type' => 'Episódio',//$faker->randomElement([ 'Episódio', 'Especial', 'Filme' ]),
		'num' => $unique_num++, //$faker->numberBetween(1, 20)
		'title' => $faker->sentence(),
	];
});

$factory->define(App\Models\Download::class, function($faker) {
	static $hosts = [ 'http://mega.nz/', 'https://drive.google.com/file/d/0B8KL1BNoXI0jblotVS1YQkE3TEE/view?usp=sharing', 'http://example.com/' ];

	$host = $faker->numberBetween(1,3);
	$quality = $faker->randomElement([ 'BD', 'HD', 'SD' ]);

	return [
		'episode_id' => $faker->numberBetween(1, 25),
		'link' => $hosts[$host-1] . $quality,
		'host_id' => $host,
		'quality' => $quality,
		'size' => $faker->biasedNumberBetween(50, 500),
	];
});

$factory->define(App\Models\Host::class, function($faker) {
	return [
		'name' => $faker->company,
		'icon' => $faker->imageUrl(250, 250),
	];
});
