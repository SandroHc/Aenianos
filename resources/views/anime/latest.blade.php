<div id="rencent" class="spotlight-cell">
	<p class="spotlight-cell-title">LANÇAMENTOS RECENTES</p>

	@foreach(\App\Models\Episode::getLatest() as $data)
		<?php $anime = $data->anime()->first() ?>
		<div class="spotlight-content">
			<a class="spotlight-link" href="{!! URL::action('AnimeController@showAnimePage', [ 'slug' => $anime->slug ]) !!}" target="_self">
				<?php $cover = !empty($anime->official_cover) ? $anime->official_cover : $anime->cover ?>
				<img class="spotlight-img" src="{{ !empty($cover) ? get_optimized_path($cover) : '/img/unknown.png' }}">

				<div class="spotlight-description">
					{{ trim($anime->title, 20) }}<br>

					<div class="spotlight-episode">
						{{ $data->getType() }} {{ $data->num }}
					</div>
				</div>
			</a>
		</div>
	@endforeach
</div>