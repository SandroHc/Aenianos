@extends('master')

@section('title', 'Notícias')

@section('content')
	<div style="position: absolute; right:16px; top: 24px">
		<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AdminController@showNewsEditor', [ 'id' => 'novo' ]) }}'">
			<i class="material-icons">add</i>
		</button>
	</div>

	<h3>Notícias</h3>

	@foreach($data as $news)
		@include('news.tile', [ 'data' => $news ])
	@endforeach

	@include('pagination', [ 'paginator' => $data ])
@endsection
