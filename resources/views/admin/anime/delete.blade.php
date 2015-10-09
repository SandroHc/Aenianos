@extends('master')

<?php $current_section = "Eliminar ". $data->title ?>

@section('content')
	{!! Form::open([ 'url' => 'admin/anime/'. $data->slug .'/eliminar', 'style' => 'width:100%' ]) !!}
	<h3>Projetos</h3>

	<p>Pretende mesmo eliminar <b>{{ $data->title }}</b>?</p>

	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
		Sim
	</button>

	<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ URL::action('AdminController@showAnimeList') }}'" value="Cancelar">

	{!! Form::close() !!}
@endsection