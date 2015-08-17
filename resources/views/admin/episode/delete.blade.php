@extends('master')

@section('title')
	Eliminar #{{ $data->num }} {{ $data->title }} - Aenianos Fansub
@endsection


@section('content')
	{!! Form::open([ 'url' => 'admin/anime/'. $data->anime_id .'/'. $data->type .'/'. $data->num .'/eliminar', 'style' => 'width:100%' ]) !!}
	<h3>Notícias</h3>

	<p>Pretende mesmo eliminar o episódio #{{ $data->num }} {{ $data->title }} do anime <b>{{ \App\Models\Anime::find($data->anime_id)->title }}</b>?</p>
	<p>Este episódio tem {{ \App\Models\Download::where('episode_id', '=', $data->id)->count() }} links ligados a ele. Esses links também serão perdidos.</p>

	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
		Sim
	</button>

	<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ URL::action('AdminController@showAnimeList') }}'" value="Cancelar">

	{!! Form::close() !!}
@endsection