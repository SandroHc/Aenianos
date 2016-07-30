<div class="mdl-card mdl-card__no-margin mdl-shadow--2dp mdl-cell mdl-cell--8-col">

	<div class="mdl-card__supporting-text mdl-card__width-fix">
		<?php
		$sectionConfig = [
				[
						$data->hasSeries(),
						'episodio',
						'Episódios',
				],
				[
						$data->hasMovies(),
						'filme',
						'Filmes',
				],
				[
						$data->hasSpecials(),
						'especial',
						'Especiais',
				],
		];
		?>

		@foreach($sectionConfig as $section)
			@if($section[0])
				<?php $quality = $data->qualityList($section[1]); ?>
				<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
					<div class="mdl-tabs__tab-bar">
						<h4 style="position: absolute; left: 15px; margin: 0; line-height: 49px;">{{ $section[2] }}</h4>
						@for($i=0; $i < sizeof($quality); $i++)
							<a href="#episodes-{{ $quality[$i]->quality }}" class="mdl-tabs__tab {{ $i === 0 ? 'is-active' : '' }}">{{ $quality[$i]->quality }}</a>
						@endfor
					</div>

					@for($i=0; $i < sizeof($quality); $i++)
						<div class="mdl-tabs__panel {{ $i === 0 ? 'is-active' : '' }}" id="episodes-{{ $quality[$i]->quality }}">
							<table>
								<tbody>
								@foreach($data->hostList($section[1], $quality[$i]->quality) as $host_id)
									<tr>
										<td>
											<?php $host = \App\Models\Host::find($host_id->host_id) ?>
											<img id="{{ $section[1] }}-{{ $quality[$i]->quality }}-{{ $host->name ?? 'unknown' }}" style="max-width:50px;max-height:50px" src="{{ $host->icon ?? '/img/unknown_circle.png' }}">
											<div class="mdl-tooltip mdl-tooltip--large" for="{{ $section[1] }}-{{ $quality[$i]->quality }}-{{ $host->name ?? 'unknown' }}">{{ $host->name ?? 'Desconhecido' }}</div>
										</td>
										<td>
											@foreach($data->episodeList($section[1], $quality[$i]->quality, $host_id->host_id) as $episode)
												<a href="{{ $episode->link }}" class="anime-link">
													@if($episode->num > 0)
														{{ trailing_zeros($episode->num) }}
													@else
														Torrent
													@endif
												</a>
											@endforeach
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					@endfor
				</div>
			@endif
		@endforeach
	</div>

	@include("disqus")
</div>