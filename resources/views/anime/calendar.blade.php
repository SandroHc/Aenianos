<div id="calendar" class="spotlight-cell">
	<p class="spotlight-cell-title">CALENDÁRIO</p>

	<?php $week = [ 'domingo', 'segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado' ]; ?>
	@foreach($week as $day)
		<div class="calendar-label">{{ $day }} <span>//</span></div>

		@foreach(\App\Models\Anime::where('status', '=', 'Em lançamento')->where('airing_week_day', '=', $day)->orderBy('title', 'ASC')->get([ 'title', 'slug', 'cover', 'official_cover' ]) as $data)
			<div class="spotlight-content">
				<a class="spotlight-link" href="{!! URL::action('AnimeController@showAnimePage', [ 'slug' => $data->slug ]) !!}" target="_self">
					<img class="spotlight-img" src="{{ !empty($data->official_cover) ? $data->official_cover : (!empty($data->cover) ? $data->cover : '/img/unknown.png') }}">
					<div class="spotlight-overlay"></div>

					<div class="spotlight-description">
						{{ cut_string($data->title, 20) }}
					</div>
				</a>
			</div>
		@endforeach
	@endforeach
</div>