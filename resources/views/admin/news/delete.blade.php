@extends('master')

<?php $current_section = "Eliminar ". $data->title ?>

@section('content')
	{!! Form::open([ 'url' => 'admin/noticias/'. $data->id .'/eliminar', 'style' => 'width:100%' ]) !!}
	<h3>Notícias</h3>

	<p>Pretende mesmo eliminar <b>{{ $data->title }}</b>?</p>

	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
		Sim
	</button>

	<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ URL::action('AdminController@showNewsList') }}'" value="Cancelar">

	{!! Form::close() !!}
@endsection