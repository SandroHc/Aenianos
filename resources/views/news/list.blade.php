@extends('master')

@section('title', 'Notícias')

@section('content')
	<h4>Notícias</h4>

	@include('news.list_lite')
@endsection


