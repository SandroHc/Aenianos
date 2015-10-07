@extends('master')

@section('content-before')
	@include('spotlight')
@endsection

@section('content')
	@include('news.list_lite')
@endsection