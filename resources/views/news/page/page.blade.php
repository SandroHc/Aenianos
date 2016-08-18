@extends('master')

<?php $current_section = $data->title ?>

@section('content')
	@include('news.tile', [ 'data' => $data, 'show_comments' => true ])
@endsection