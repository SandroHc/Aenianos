<div class="anime-header">
	<div class="anime-header__sub">
		<h1>{{ $data->title }} <span style="font-size: 28px; color: #969696; ">/ {{ $data->status }}</span></h1>

		@if(Auth::check())
			<div style="position: absolute; top: 0; right: 0;">
				<button id="news-{{ $data->id }}" class="mdl-button mdl-js-button mdl-button--icon">
					<i class="material-icons">more_vert</i>
				</button>

				<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="news-{{ $data->id }}">
					<a href="{!! URL::action('AdminController@showAnimeEditor', [ 'slug' => $data->slug ]) !!}" target="_self" style="text-decoration: none"><li class="mdl-menu__item">Editar</li></a>
					<a href="{!! URL::action('AdminController@deleteAnimePrompt', [ 'slug' => $data->slug ]) !!}" target="_self" style="text-decoration: none"><li class="mdl-menu__item">Remover</li></a>
				</ul>

				<div style="position: absolute; right:16px; top: 72px">
					<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AdminController@showEpisodeEditor', [ 'id' => $data->id, 'type' => 'episodio', 'num' => 'novo' ]) }}'">
						<i class="material-icons">add</i>
					</button>
				</div>
			</div>
		@endif

		<div style="width: 100%; background-color: rgba(150, 150, 150, 0.5); position: relative; ">
			@if(!empty($data->cover))
				<img src="/{{ $data->cover }}">
			@endif
			<div style="width: calc(100% - 280px); padding: 40px; color: #FFF; float: right">
				{!! $data->synopsis !!}
			</div>
		</div>
	</div>
</div>