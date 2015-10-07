@extends('master')

<?php $current_section = $data->title ?>

@section('content')
	@include('anime.anime', [ 'data' => $data ])
@endsection