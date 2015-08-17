@extends('master')

@section('title')
	Procurar por {{ $search }} - Aenianos Fansub
@endsection

@section('content')
	<h3>Pesquisa</h3>

	<p class="paragraph-full">Pesquisando pelo termo <b>{{ $search }}</b>.</p>

	@if($paginator != NULL)
		@forelse($paginator as $cur)
			@if($cur['type'] == 'anime')
				@include('anime.tile', [ 'data' => \App\Models\Anime::find($cur['db_id']) ])
			@elseif($cur['type'] == 'news')
				@include('news.tile', [ 'data' => \App\Models\News::find($cur['db_id']) ])
			@endif
		@empty
			<p>Nenhum resultado foi encontrado.</p>
		@endforelse

		@include('pagination')
	@else
		<p>Nenhum resultado foi encontrado.</p>
	@endif
@endsection