<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--8-col">
	@if(!empty($data->cover))
		<a href="{!! URL::action('AnimeController@showAnimePage', [ 'slug' => $data->slug ]) !!}" target="_self">
			<div style="background: url('{{ $data->cover }}') 0 {{ $data->cover_offset }}% / cover; height: 200px"></div>
		</a>
	@endif

	<div class="mdl-card__title" style="padding-bottom:7px">
		<h2 class="mdl-card__title-text">
			<a href="{!! URL::action('AnimeController@showAnimePage', [ 'slug' => $data->slug ]) !!}" target="_self" style="text-decoration: none">{{ $data->title }}</a>
		</h2>

		@if(Auth::check() && Auth::user()->admin)
			<button id="anime-{{ $data->id }}" class="mdl-button mdl-js-button mdl-button--icon" style="{{ empty($data->cover) ? 'margin-right: 126px' : '' }}">
				<i class="material-icons">more_vert</i>
			</button>

			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="anime-{{ $data->id }}">
				<a href="{!! URL::action('AdminController@showAnimeEditor', [ 'slug' => $data->slug ]) !!}" target="_self" style="text-decoration: none"><li class="mdl-menu__item">Editar</li></a>
				<a href="{!! URL::action('AdminController@deleteAnimePrompt', [ 'slug' => $data->slug ]) !!}" target="_self" style="text-decoration: none"><li class="mdl-menu__item">Remover</li></a>
			</ul>

			<div style="position:absolute; right:16px; top:24px">
				<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{!! URL::action('AdminController@showEpisodeEditor', [ 'id' => $data->id, 'type' => 'episodio', 'num' => 'novo' ]) !!}'">
					<i class="material-icons">add</i>
				</button>
			</div>
		@endif
	</div>

	<div class="mdl-card__supporting-text mdl-card--no-padding">
		/ {{ $data->status }} /
	</div>

	<div class="anime-tile__synopsis mdl-card__supporting-text mdl-card--no-padding">
		{{-- TODO: Truncate long synopsis! Currently only hinding overflow --}}
		{!! $data->synopsis !!}
	</div>
</div>