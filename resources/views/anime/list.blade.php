@extends('master')

<?php $current_section = "Projetos" ?>

@section('content')
	@if(Auth::check() && Auth::user()->admin)
		<div style="position: absolute; right:16px; top: 24px">
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AnimeController@add') }}'">
				<i class="material-icons">add</i>
			</button>
		</div>
	@endif

	@foreach($paginator = \App\Models\Anime::orderBy('created_at', 'DESC')->paginate(10) as $data)
		@include('anime.tile')
		<br>
	@endforeach

	@include('pagination')
@endsection