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
				<a href="{!! URL::action('AdminController@showAnimeEditor', [ 'id' => $data->id ]) !!}" target="_self" style="text-decoration: none"><li class="mdl-menu__item">Editar</li></a>
				<a href="{!! URL::action('AdminController@deleteAnimePrompt', [ 'id' => $data->id ]) !!}" target="_self" style="text-decoration: none"><li class="mdl-menu__item">Remover</li></a>
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

		<hr>

		@if($data->hasSeries())
			<h4>Episódios</h4>

			@foreach($data->qualityList('episodio') as $quality)
				<h5>{{ !empty($quality->quality) ? $quality->quality : 'Outros' }}</h5>

				<div class="mdl-grid">
					@foreach($data->hostList('episodio', $quality->quality) as $host)
						<div class="mdl-grid mdl-cell mdl-cell--12-col episode-spacing">
							<div class="mdl-cell mdl-cell--3-col">
								<img src="http://www.google.com/s2/favicons?domain={{ get_host_domain($host->host_name) }}" class="download-link-icon"> {{ $host->host_name }}
							</div>

							<div class="mdl-cell mdl-cell--9-col">
								@foreach($data->episodeList('episodio', $quality->quality, $host->host_name) as $episode)
									<a href="{{ $episode->host_link }}" class="anime-link">
										@if($episode->num > 0)
											{{ $episode->num < 10 ? '0'. $episode->num : $episode->num }}
										@else
											Torrent
										@endif
									</a>
								@endforeach
							</div>
						</div>
					@endforeach
				</div>
			@endforeach
		@endif

		@if($data->hasMovies())
			<h4>Filmes</h4>

			@foreach($data->qualityList('filme') as $quality)
				<h5>{{ !empty($quality->quality) ? $quality->quality : 'Outros' }}</h5>

				<div class="mdl-grid">
					@foreach($data->hostList('filme', $quality->quality) as $host)
						<div class="mdl-grid mdl-cell mdl-cell--12-col episode-spacing">
							<div class="mdl-cell mdl-cell--3-col">
								<img src="http://www.google.com/s2/favicons?domain={{ get_host_domain($host->host_name) }}" class="download-link-icon"> {{ $host->host_name }}
							</div>

							<div class="mdl-cell mdl-cell--9-col">
								@foreach($data->episodeList('filme', $quality->quality, $host->host_name) as $episode)
									<a href="{{ $episode->host_link }}" class="anime-link">
										@if($episode->num > 0)
											{{ trailing_zeros($episode->num) }}
										@else
											Torrent
										@endif
									</a>
								@endforeach
							</div>
						</div>
					@endforeach
				</div>
			@endforeach
		@endif

		@if($data->hasSpecials())
			<h4>Especiais</h4>

			@foreach($data->qualityList('especial') as $quality)
				<h5>{{ !empty($quality->quality) ? $quality->quality : 'Outros' }}</h5>

				<div class="mdl-grid">
					@foreach($data->hostList('especial', $quality->quality) as $host)
						<div class="mdl-grid mdl-cell mdl-cell--12-col episode-spacing">
							<div class="mdl-cell mdl-cell--3-col">
								<img src="http://www.google.com/s2/favicons?domain={{ get_host_domain($host->host_name) }}" class="download-link-icon"> {{ $host->host_name }}
							</div>

							<div class="mdl-cell mdl-cell--9-col">
								@foreach($data->episodeList('especial', $quality->quality, $host->host_name) as $episode)
									<a href="{{ $episode->host_link }}" class="anime-link">
										@if($episode->num > 0)
											{{ $episode->num < 10 ? '0'. $episode->num : $episode->num }}
										@else
											Torrent
										@endif
									</a>
								@endforeach
							</div>
						</div>
					@endforeach
				</div>
			@endforeach
		@endif
	</div>

	@include("disqus")
</div>