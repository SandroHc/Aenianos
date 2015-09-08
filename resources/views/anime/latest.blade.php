<div id="rencent" class="spotlight-cell">
	<p class="spotlight-cell-title">LANÇAMENTOS RECENTES</p>

	@foreach(\App\Models\Episode::getLatestEpisodes() as $data)
		<?php $anime = $data->anime()->get()[0]; ?>
		<div class="spotlight-content">
			<a class="spotlight-link" href="{!! URL::action('AnimeController@showDetailSlug', [ 'slug' => $anime->slug ]) !!}" target="_self">
				<img class="spotlight-img" src="{{ !empty($anime->official_cover) ? $anime->official_cover : (!empty($anime->cover) ? $anime->cover : '/img/unknown.png') }}">
				<div class="spotlight-overlay"></div>

				<div class="spotlight-description">
					{{ trim($anime->title, 20) }}<br>
					<div class="spotlight-episode">Ep. {{ $data->num }}</div>
				</div>
			</a>
		</div>
	@endforeach
</div>