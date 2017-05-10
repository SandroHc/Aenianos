<div class="anime-tile mdl-card mdl-shadow--2dp">
	@if(empty($data->cover) && !empty($data->official_cover))
		<a href="{!! URL::action('show', [ 'slug' => $data->slug ]) !!}" target="_self" class="anime-tile__cover mdl-cell--hide-phone mdl-cell--hide-tablet">
			<img src="{{ get_optimized_path($data->official_cover) }}" class="anime-tile__cover mdl-cell--hide-phone mdl-cell--hide-tablet">
		</a>
	@endif

	<div class="anime-tile__synopsis">
		@if(!empty($data->cover))
			<a href="{!! URL::action('show', [ 'slug' => $data->slug ]) !!}" target="_self">
				<div style="background: url('{{ $data->cover }}') 0 {{ $data->cover_offset }}% / cover; height: 200px"></div>
			</a>
		@endif

		<div class="mdl-card__title">
			<h2 class="mdl-card__title-text">
				<a href="{!! URL::action('show', [ 'slug' => $data->slug ]) !!}" target="_self">{{ $data->title }}</a><span>&nbsp; / {{ $data->status }}</span>
			</h2>

			@if(Auth::check() && Auth::user()->admin)
				<button id="anime-{{ $data->id }}" class="mdl-button mdl-js-button mdl-button--icon">
					<i class="material-icons">more_vert</i>
				</button>

				<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="anime-{{ $data->id }}">
					<a class="text-decoration--none" href="{!! URL::action('AnimeController@manage', [ 'slug' => $data->slug ]) !!}" target="_self"><li class="mdl-menu__item">Editar</li></a>
					<a class="text-decoration--none" href="{!! URL::action('AnimeController@deleteWarning', [ 'slug' => $data->slug ]) !!}" target="_self"><li class="mdl-menu__item">Remover</li></a>
				</ul>
			@endif
		</div>

		<div class="anime-tile__synopsis mdl-card__supporting-text mdl-card--no-padding">
			{{-- TODO: Truncate long synopsis! Currently only hinding overflow --}}
			{!! $data->synopsis !!}
		</div>
	</div>
</div>