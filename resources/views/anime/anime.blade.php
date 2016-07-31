<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp mdl-cell mdl-cell--8-col">

	<div class="mdl-card__supporting-text mdl-card--no-padding">
		<?php
		const AVAILABLE = 0;
		const NAME = 1;
		const TITLE = 2;

		$sectionConfig = [
				[
						$data->hasSeries(),
						'Episódio',
						'Episódios',
				],
				[
						$data->hasSpecials(),
						'Especial',
						'OVAs',
				],
				[
						$data->hasMovies(),
						'Filme',
						'Filmes',
				],
		];
		?>

		@foreach($sectionConfig as $section)
			@if($section[AVAILABLE])
				<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
					<div class="mdl-tabs__tab-bar">
						<h4 style="position: absolute; left: 15px; margin: 0; line-height: 49px;">{{ $section[TITLE] }}</h4>
						<?php $quality = $data->qualityList($section[NAME]); ?>
						@for($i=0; $i < sizeof($quality); $i++)
							<a href="#episodes-{{ $quality[$i]->quality }}" class="mdl-tabs__tab {{ $i === 0 ? 'is-active' : '' }}">{{ $quality[$i]->quality }}</a>
						@endfor
					</div>

					<?php
						$episodes_available = $data->availableEpisodes($section[NAME]);
					?>

					@for($i=0; $i < sizeof($quality); $i++)
						<div class="mdl-tabs__panel {{ $i === 0 ? 'is-active' : '' }}" id="episodes-{{ $quality[$i]->quality }}">
							<table class="download-section__table">
								<tbody>
								<?php
									$episode_list = $data->episodeList($section[NAME], $quality[$i]->quality);

									$episode_list_keys = [];
									foreach($episode_list as $episode)
										$episode_list_keys[$episode->num] = $episode;
								?>

								@foreach($episodes_available as $episode_base)
									<?php
										$has_episode = array_key_exists($episode_base->num, $episode_list_keys);

										if($has_episode)
											$episode = $episode_list_keys[$episode_base->num];
									?>
									<tr id="{{ $section[NAME] }}-{{ $episode_base->num }}-{{ $quality[$i]->quality }}" class="has-dl {{ !$has_episode ? 'disabled' : '' }}">
										<td>
											@if($episode->num > 0)
												{{ trailing_zeros($episode_base->num) }}
											@else
												Batch
											@endif
										</td>
										<td>
											{{ $episode_base->title }}
										</td>
									</tr>
									@if($has_episode)
										<tr id="{{ $section[NAME] }}-{{ $episode->num }}-{{ $quality[$i]->quality }}-dl" class="download hidden">
											<td colspan="2">
											@foreach($episode->downloads()->orderBy('host_id', 'ASC')->get() as $download)
												<a href="{{ $download->link }}" class="button-link">
													@if($download->host != NULL)
														{{ $download->host->name }}
													@else
														?
													@endif
												</a>
											@endforeach
											</td>
										</tr>
									@endif
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