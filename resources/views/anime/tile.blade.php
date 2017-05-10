<div class="anime-tile mdl-card mdl-shadow--2dp">
	@if(empty($anime->cover) && !empty($anime->official_cover))
		<a href="{{ action('AnimeController@show', [ $anime->slug ]) }}" target="_self" class="anime-tile__cover mdl-cell--hide-phone mdl-cell--hide-tablet">
			<img src="{{ get_optimized_path($anime->official_cover) }}" class="anime-tile__cover mdl-cell--hide-phone mdl-cell--hide-tablet">
		</a>
	@endif

	<div class="anime-tile__synopsis">
		@if(!empty($anime->cover))
			<a href="{{ action('AnimeController@show', [ $anime->slug ]) }}" target="_self">
				<div style="background: url('{{ $anime->cover }}') 0 {{ $anime->cover_offset }}% / cover; height: 200px"></div>
			</a>
		@endif

		<div class="mdl-card__title">
			<h2 class="mdl-card__title-text">
				<a href="{{ action('AnimeController@show', [ $anime->slug ]) }}" target="_self">{{ $anime->title }}</a><span>&nbsp; / {{ $anime->status }}</span>
			</h2>

			@if(Auth::check() && Auth::user()->admin)
				<button id="anime-{{ $anime->id }}" class="mdl-button mdl-js-button mdl-button--icon">
					<i class="material-icons">more_vert</i>
				</button>

				<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="anime-{{ $anime->id }}">
					<a class="text-decoration--none" href="{!! URL::action('AnimeController@edit', [ $anime->slug ]) !!}" target="_self"><li class="mdl-menu__item">Editar</li></a>
					<a class="text-decoration--none" href="{!! URL::action('AnimeController@destroyWarning', [ $anime->slug ]) !!}" target="_self"><li class="mdl-menu__item">Remover</li></a>
				</ul>
			@endif
		</div>

		<div class="anime-tile__synopsis mdl-card__supporting-text mdl-card--no-padding">
			{{-- TODO: Truncate long synopsis! Currently only hinding overflow --}}
			{!! $anime->synopsis !!}
		</div>
	</div>
</div>