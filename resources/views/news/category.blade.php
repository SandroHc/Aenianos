@extends('master')

@section('title', $data->name)

@section('content')
	<h4><span class="navigation-parent"><a href="{{ action('NewsController@list') }}" target="_self">Notícias</a> ></span> {{ $data->name }}</h4>
	<p>{{ $data->description }}</p>

	@foreach($paginator = \App\Models\News::where('category_id', '=', $data->id)->orderBy('created_at', 'DESC')->paginate(10) as $news)
		@include('news.tile', [ 'data' => $news ])
	@endforeach

	@include('pagination')
@endsection

