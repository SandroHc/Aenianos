@extends('master')

<?php $current_section = "Eliminar ". $data->title ?>

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp mdl-cell mdl-cell--8-col">
		<div class="mdl-card__supporting-text mdl-card--no-padding">

			{!! Form::open([ 'url' => URL::action('AnimeController@delete', [ 'slug' => $data->slug ]), 'method' => 'delete', 'style' => 'width:100%' ]) !!}
			<h3>Projetos</h3>

			<p>Pretende mesmo eliminar <b>{{ $data->title }}</b>?</p>

			<br>

			<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
				Sim
			</button>

			<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ URL::action('AnimeController@page', [ 'slug' => $data->slug ]) }}'" value="Cancelar">

			{!! Form::close() !!}

		</div>
	</div>
@endsection