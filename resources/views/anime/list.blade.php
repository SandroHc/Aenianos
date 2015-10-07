@extends('master')

<?php $current_section = "Projetos" ?>

@section('content')
	@foreach($paginator = \App\Models\Anime::orderBy('created_at', 'DESC')->paginate(10) as $data)
		@include('anime.tile')
		<br>
	@endforeach

	@include('pagination')
@endsection