@extends('master')

<?php $current_section = $data->title ?>

@section('content')
	<h4><span class="navigation-parent"><a href="{{ URL::action('NewsController@showList') }}" target="_self">Notícias</a> >{{-- <a href="{{ URL::action('NewsController@showCategoryList', [ 'id' => $data->id_category ]) }}" target="_self">{{ \App\Models\NewsCategory::find($data->id_category)->name }}</a> >--}}</span> {{ $data->title }}</h4>

	@include('news.tile', [ 'data' => $data, 'show_comments' => true ])
@endsection