@extends('master')

<?php $current_section = $search ?>

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp mdl-cell mdl-cell--8-col">
		<div class="mdl-card__supporting-text mdl-card--no-padding">
			<h3>Pesquisa</h3>

			<p class="paragraph-full">Pesquisando pelo termo <b>{{ $search }}</b>.</p>
		</div>
	</div>

	@if($paginator != NULL)
		@forelse($paginator as $cur)
			@if($cur['type'] == 'anime')
				<?php $data = \App\Models\Anime::find($cur['db_id']) ?>
				@if($data != NULL)
					@include('anime.tile', [ 'data' => $data ])
				@endif
			@elseif($cur['type'] == 'news')
				<?php $data = \App\Models\News::find($cur['db_id']) ?>
				@if($data != NULL)
					@include('news.tile', [ 'data' => $data ])
				@endif
			@endif
		@empty
			<p>Nenhum resultado foi encontrado.</p>
		@endforelse

		@include('pagination')
	@else
		<p>Nenhum resultado foi encontrado.</p>
	@endif
@endsection