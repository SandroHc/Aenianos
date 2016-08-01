@extends('master')

<?php $current_section = "Push Notifications" ?>

@section('content')
	<h3>Sending push notification...</h3>

	<?php
	$API_ACCESS_KEY = env('PUSH_KEY');

	$endpoints = [
		'c8HIsC4Csq8:APA91bEERS8zZSCo9Cdm9A3ts8IvcvEr5XyuRWE2PRWtOCR7PJRBGu3sKqDd3QLGjTb65nWnt1tzjjC23Pee2BbEM8wn-QimxDDNampXrmBS6m4dZEL2SmBWlDmIvGYFFWKBPK8-fHbG',
	];


	$url = 'https://android.googleapis.com/gcm/send';

	$headers = [
			'Authorization: key=' . $API_ACCESS_KEY,
			'Content-Type: application/json'
	];

	$message = [
			'title' => 'Aenianos',
			'description' => 'Teste',
			'icon' => '/img/upload/Shigatsu wa Kimi no Uso.jpg'
	];

	$fields = [
			'registration_ids' => $endpoints,
			'data' => $message,
	];


	$ch = curl_init();
	// Set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// Disabling SSL Certificate support temporarily
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));


	// Execute post
	$result = curl_exec($ch);

	?>
	<p>
		@if($result === FALSE)
			Error: {{  curl_error($ch) }}
		@else
			{{ $result }}
		@endif
	</p>
	<?php

	// Close connection
	curl_close($ch);

	?>
@endsection
