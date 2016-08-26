@extends('master')

@section('title', $search)

@push('scripts')
	<script src="{{ asset('js/getmdl-select.min.js') }}" async></script>
	<script src="{{ asset('js/jquery.highlight.min.js') }}"></script>
	<script defer async>
		$(window).load(function() {
			$('#search-results').highlight('{{ $search }}');
			console.log('HIGH! $(\'#search-results\').highlight(\'{{ $search }}\')');
		});
	</script>
@endpush

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp">
		<div class="mdl-card__supporting-text mdl-card--no-padding">
			<h3>Pesquisa</h3>

			<p class="paragraph-full">Pesquisando pelo termo <b>{{ !empty($search) ? $search : '?' }}</b>. {{ sizeof($paginator) }} resultados.</p>

			<h4>Avançado</h4>

			{!! Form::open([ 'url' => URL::action('GeneralController@search'), 'style' => 'margin:0 auto' ]) !!}

			<div class="mdl-grid mdl-grid--no-spacing">
				<div class="mdl-cell mdl-cell--6-col mdl-textfield mdl-js-textfield">
					Pesquisa
					<input class="mdl-textfield__input" type="text" name="search" value="{{ $search ?? old('search')  }}" required="" id="input" />
					<label class="mdl-textfield__label" for="title"></label>
				</div>

				{{--<div>--}}
					<div class="mdl-cell mdl-cell--4-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select" style="width: inherit">
						<input class="mdl-textfield__input" type="text" name="type" id="type" value="{{ $type ?? old('type', 'Todos') }}" readonly tabIndex="-1">
						<label for="type">
							<i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
						</label>
						<label for="status" class="mdl-textfield__label">Tipo</label>
						<ul for="type" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
							<li class="mdl-menu__item">Todos</li>
							<li class="mdl-menu__item">Projetos</li>
							<li class="mdl-menu__item">Notícias</li>
						</ul>
					</div>
				{{--</div>--}}

				<button type="submit" class="mdl-cell mdl-cell--2-col mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
					Procurar
				</button>
			</div>

			{!! Form::close() !!}

		</div>
	</div>

	<span id="search-results">
		<?php $no_results = false ?>
		@if($paginator != NULL)
			@forelse($paginator as $cur)
				@if($cur['_type'] == 'anime')
					@if(($data = \App\Models\Anime::get($cur['id'])) != NULL)
						@include('anime.tile', [ 'data' => $data ])
					@endif
				@elseif($cur['_type'] == 'news')
					@if(($data = \App\Models\News::get($cur['id'])) != NULL)
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
	</span>

	@if($no_results)
		<div class="mdl-card mdl-shadow--2dp">
			<div class="mdl-card__supporting-text">
				<i class="material-icons">warning</i> Nenhum resultado foi encontrado.
			</div>
		</div>
	@endif
@endsection