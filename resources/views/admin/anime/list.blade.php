@extends('master')

@section('title')
	Projetos - Aenianos Fansub
@endsection

@section('content')
	<div style="position: absolute; right:16px; top: 24px">
		<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AdminController@showAnimeEditor', [ 'id' => 'novo' ]) }}'">
			<i class="material-icons">add</i>
		</button>
	</div>

	<h3>Projetos</h3>

	@foreach($paginator = \App\Models\Anime::orderBy('updated_at', 'DESC')->paginate(10) as $anime)
		@include('anime.tile', [ 'data' => $anime ])
	@endforeach

	@include('pagination')
@endsection
