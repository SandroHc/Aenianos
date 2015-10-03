@extends('master')

@section('title', 'Aenianos Fansub')

@section('content-before')
	@include('spotlight')
@endsection

@section('content')
	@include('news.list_lite')
@endsection