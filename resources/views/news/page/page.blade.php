@extends('master')

@section('title', $data->title)

@section('content')
	@include('news.tile', [ 'data' => $data, 'show_comments' => true ])
@endsection