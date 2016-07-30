@extends('master')

<?php $current_section = $data->title ?>

@section('content-before')
	@include('anime.anime_header', [ 'data' => $data ])
@endsection

@section('content')
	@include('anime.anime', [ 'data' => $data ])
@endsection