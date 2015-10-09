<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--8-col" style="margin: 15px auto">
	@if(!empty($data->cover))
		<div style="background: url('{{ $data->cover }}') 0 {{ $data->cover_offset }}px / cover; height: 200px"></div>
	@endif

	<div class="mdl-card__title" style="padding-bottom:7px">
		<h2 class="mdl-card__title-text">
			{{ $data->title }}
		</h2>

		@if(Auth::check())
			<button id="news-{{ $data->id }}" class="mdl-button mdl-js-button mdl-button--icon">
				<i class="material-icons">more_vert</i>
			</button>

			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="news-{{ $data->id }}">
				<a href="{!! URL::action('AdminController@showAnimeEditor', [ 'slug' => $data->slug ]) !!}" target="_self" style="text-decoration: none"><li class="mdl-menu__item">Editar</li></a>
				<a href="{!! URL::action('AdminController@deleteAnimePrompt', [ 'slug' => $data->slug ]) !!}" target="_self" style="text-decoration: none"><li class="mdl-menu__item">Remover</li></a>
			</ul>

			<div style="position: absolute; right:16px; top: {{ !empty($data->cover) ? 24 : 72 }}px">
				<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AdminController@showEpisodeEditor', [ 'id' => $data->id, 'type' => 'episodio', 'num' => 'novo' ]) }}'">
					<i class="material-icons">add</i>
				</button>
			</div>
		@endif
	</div>

	<div class="mdl-card__supporting-text mdl-card__width-fix">
		{{ $data->status }}
	</div>

	<div class="mdl-card__supporting-text mdl-card__width-fix">
		{!! $data->synopsis !!}

		@if($data->hasSeries())
			<?php
			$section = 'episodio';
			$quality = $data->qualityList($section);
			?>
			<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
				<div class="mdl-tabs__tab-bar">
					<h4 style="position: absolute; left: 15px; margin: 0; line-height: 49px;">Episódios</h4>
					@for($i=0; $i < sizeof($quality); $i++)
						<a href="#episodes-{{ $quality[$i]->quality }}" class="mdl-tabs__tab {{ $i === 0 ? 'is-active' : '' }}">{{ $quality[$i]->quality }}</a>
					@endfor
				</div>

				@for($i=0; $i < sizeof($quality); $i++)
					<div class="mdl-tabs__panel {{ $i === 0 ? 'is-active' : '' }}" id="episodes-{{ $quality[$i]->quality }}">
						<ul>
							@foreach($data->hostList($section, $quality[$i]->quality) as $host)
								<li>
									@foreach($data->episodeList($section, $quality[$i]->quality, $host->host_name) as $episode)
										<a href="{{ $episode->host_link }}" class="anime-link">
											@if($episode->num > 0)
												{{ trailing_zeros($episode->num) }}
											@else
												Torrent
											@endif
										</a>
									@endforeach
								</li>
							@endforeach
						</ul>
					</div>
				@endfor
			</div>
		@endif

		@if($data->hasMovies())
			<?php
			$section = 'filme';
			$quality = $data->qualityList($section);
			?>
			<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
				<div class="mdl-tabs__tab-bar">
					<h4 style="position: absolute; left: 15px; margin: 0; line-height: 49px;">Filmes</h4>
					@for($i=0; $i < sizeof($quality); $i++)
						<a href="#movies-{{ $quality[$i]->quality }}" class="mdl-tabs__tab {{ $i === 0 ? 'is-active' : '' }}">{{ $quality[$i]->quality }}</a>
					@endfor
				</div>

				@for($i=0; $i < sizeof($quality); $i++)
					<div class="mdl-tabs__panel {{ $i === 0 ? 'is-active' : '' }}" id="movies-{{ $quality[$i]->quality }}">
						<ul>
							@foreach($data->hostList($section, $quality[$i]->quality) as $host)
								<li>
									@foreach($data->episodeList($section, $quality[$i]->quality, $host->host_name) as $episode)
										<a href="{{ $episode->host_link }}" class="anime-link">
											@if($episode->num > 0)
												{{ trailing_zeros($episode->num) }}
											@else
												Torrent
											@endif
										</a>
									@endforeach
								</li>
							@endforeach
						</ul>
					</div>
				@endfor
			</div>
		@endif

		@if($data->hasSpecials())
			<?php
			$section = 'especial';
			$quality = $data->qualityList($section);
			?>
			<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
				<div class="mdl-tabs__tab-bar">
					<h4 style="position: absolute; left: 15px; margin: 0; line-height: 49px;">Especiais</h4>
					@for($i=0; $i < sizeof($quality); $i++)
						<a href="#specials-{{ $quality[$i]->quality }}" class="mdl-tabs__tab {{ $i === 0 ? 'is-active' : '' }}">{{ $quality[$i]->quality }}</a>
					@endfor
				</div>

				@for($i=0; $i < sizeof($quality); $i++)
					<div class="mdl-tabs__panel {{ $i === 0 ? 'is-active' : '' }}" id="specials-{{ $quality[$i]->quality }}">
						<ul>
							@foreach($data->hostList($section, $quality[$i]->quality) as $host)
								<li>
									@foreach($data->episodeList($section, $quality[$i]->quality, $host->host_name) as $episode)
										<a href="{{ $episode->host_link }}" class="anime-link">
											@if($episode->num > 0)
												{{ trailing_zeros($episode->num) }}
											@else
												Torrent
											@endif
										</a>
									@endforeach
								</li>
							@endforeach
						</ul>
					</div>
				@endfor
			</div>
		@endif
	</div>

	@include("disqus")
</div>