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
						<h4>{{ $section[TITLE] }}</h4>
						<?php $quality_list = $data->qualityList($section[NAME]); ?>
						<?php $is_first = true ?>
						@foreach($quality_list as $quality)
							<a href="#{{ $section[NAME] }}-{{ $quality->quality }}" class="mdl-tabs__tab {{ $is_first ? 'is-active' : '' }}">{{ $quality->quality }}</a>
							<?php $is_first = false ?>
						@endforeach
					</div>

					<?php $episodes_available = $data->availableEpisodes($section[NAME]); ?>

					<?php $is_first = true ?>
					@forelse($quality_list as $quality)
						<div class="mdl-tabs__panel {{ $is_first ? 'is-active' : '' }}" id="{{ $section[NAME] }}-{{ $quality->quality }}">
							<?php $is_first = false ?>
							<table class="download-section__table">
								<tbody>
								<?php
									$episode_list = $data->episodeList($section[NAME], $quality->quality);

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
									<tr id="{{ $section[NAME] }}-{{ $episode_base->num }}-{{ $quality->quality }}" class="has-dl {{ !$has_episode ? 'disabled' : '' }}">
										<td>
											@if($episode_base->num > 0)
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
										<tr id="{{ $section[NAME] }}-{{ $episode->num }}-{{ $quality->quality }}-dl" class="download hidden">
											<td colspan="2">
											@foreach($episode->downloads()->orderBy('host_id', 'ASC')->get() as $download)
												<a href="{{ $download->link }}" class="button-link">
													<img src="{{ $download->host->icon ?? '/img/unknown_circle.png' }}">
													{{ $download->host->name ?? '' }}
												</a>
											@endforeach
											</td>
										</tr>
									@endif
								@endforeach
								</tbody>
							</table>
						</div>
					@empty
						<div class="mdl-tabs__panel is-active" id="{{ $section[NAME] }}">
							<table class="download-section__table">
								<tbody>
								@foreach($episodes_available as $episode_base)
									<tr id="{{ $section[NAME] }}-{{ $episode_base->num }}" class="has-dl disabled">
										<td>
											@if($episode_base->num > 0)
												{{ trailing_zeros($episode_base->num) }}
											@else
												Batch
											@endif
										</td>
										<td>
											{{ $episode_base->title }}
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					@endforelse
				</div>
			@endif
		@endforeach
	</div>

	@include("disqus")
</div>