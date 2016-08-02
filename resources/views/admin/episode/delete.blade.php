@extends('master')

<?php $current_section = "Eliminar #". $data->num ?>

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp mdl-cell mdl-cell--8-col">
		<div class="mdl-card__supporting-text mdl-card--no-padding">

			{!! Form::open([ 'url' => URL::action('EpisodeController@delete', [ 'slug' => $data->anime, 'type' => $data->type, 'num' => $data->num ]), 'method' => 'delete', 'style' => 'width:100%' ]) !!}
			<h3>Notícias</h3>

			<p>Pretende mesmo eliminar o episódio #{{ $data->num }} do anime <b>{{ \App\Models\Anime::get($data->anime)->title }}</b>?</p>
			<p>Este episódio tem {{ \App\Models\Episode::get($data->anime, $data->type, $data->num)->count() }} links. Esses links também serão eliminados.</p>

			<br>

			<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
				Sim
			</button>

			<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ URL::action('AdminController@showAnimeEditor', [ 'slug' => $data->anime ]) }}'" value="Cancelar">

			{!! Form::close() !!}

		</div>
	</div>
@endsection