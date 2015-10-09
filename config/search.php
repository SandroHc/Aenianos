<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Default Search Driver
	|--------------------------------------------------------------------------
	|
	| The search API supports a variety of back-ends via a unified
	| API, giving you convenient access to each back-end using the same
	| syntax for each one. Here you may set the default search driver.
	|
	| Supported: "zend", "elasticsearch", "algolia"
	|
	*/

	'default' => 'zend',

	/*
	|--------------------------------------------------------------------------
	| Default Index
	|--------------------------------------------------------------------------
	|
	| Specify the default index to use when an index is not specified.
	|
	*/

	'default_index' => 'default',

	/*
	|--------------------------------------------------------------------------
	| Search Connections
	|--------------------------------------------------------------------------
	|
	| Here you may configure the connection information for each server that
	| is used by your application. A default configuration has been added
	| for each back-end shipped with this package. You are free to add more.
	|
	*/

	'connections' => [

		'zend' => [
			'driver' => 'zend',
			'path'   => storage_path().'/search',
		],

		'elasticsearch' => [
			'driver' => 'elasticsearch',
			'config' => [
				'hosts' => [
					'localhost:9200'
				],
			],
		],

		'algolia' => [
			'driver' => 'algolia',
			'config' => [
				'application_id' => '',
				'admin_api_key'  => '',
			],
		],
	],
];
