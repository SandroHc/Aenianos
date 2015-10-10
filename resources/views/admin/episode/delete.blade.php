@extends('master')

<?php $current_section = "Eliminar #". $data->num ?>

@section('content')
	{!! Form::open([ 'url' => URL::action('AdminController@deleteEpisode', [ 'slug' => $data->anime, 'type' => $data->type, 'num' => $data->num ]), 'style' => 'width:100%' ]) !!}
	<h3>Notícias</h3>

	<p>Pretende mesmo eliminar o episódio #{{ $data->num }} do anime <b>{{ \App\Models\Anime::get($data->anime)->title }}</b>?</p>
	<p>Este episódio tem {{ \App\Models\Episode::get($slug, '=', $data->id)->count() }} links ligados a ele. Esses links também serão perdidos.</p>

	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
		Sim
	</button>

	<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ URL::action('AdminController@showAnimeList') }}'" value="Cancelar">

	{!! Form::close() !!}
@endsection