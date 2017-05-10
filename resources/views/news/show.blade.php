@extends('master')

@section('title', $news->title)

@section('content')
	@include('news.tile', [ 'show_comments' => true ])
@endsection