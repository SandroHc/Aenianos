@extends('master')

@section('title', $search)

@push('scripts')
	<script src="{{ asset('js/jquery.highlight.min.js') }}"></script>
	<script defer async>
		$('#search-results').highlight('{{ $search }}');
		console.log('HIGH! $(\'#search-results\').highlight(\'{{ $search }}\')');
	</script>
@endpush

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp">
		<div class="mdl-card__supporting-text mdl-card--no-padding">
			<h3>Pesquisa</h3>

			<p class="paragraph-full">Pesquisando pelo termo <b>{{ !empty($search) ? $search : '?' }}</b>. {{ sizeof($paginator) }} resultados.</p>
		</div>
	</div>

	<span id="search-results">
		<?php $no_results = false ?>
		@if($paginator != NULL)
			@forelse($paginator as $cur)
				@if($cur['type'] == 'anime')
					@if(($data = \App\Models\Anime::find($cur['db_id'])) != NULL)
						@include('anime.tile', [ 'data' => $data ])
					@endif
				@elseif($cur['type'] == 'news')
					@if(($data = \App\Models\News::find($cur['db_id'])) != NULL)
						@include('news.tile', [ 'data' => $data ])
					@endif
				@endif
			@empty
				<?php $no_results = true ?>
			@endforelse

			@include('pagination')
		@else
			<?php $no_results = true ?>
		@endif

		@if($no_results)
			<div class="mdl-card mdl-shadow--2dp">
				<div class="mdl-card__supporting-text">
					Nenhum resultado foi encontrado.
				</div>
			</div>
		@endif
	</span>
@endsection