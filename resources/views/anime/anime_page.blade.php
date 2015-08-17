@extends('master')

@section('title')
	{{ $data->title }} - Aenianos Fansub
@endsection

@section('content')
	@include('anime.anime', [ 'data' => $data ])
@endsection