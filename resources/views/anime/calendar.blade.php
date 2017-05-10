<div id="calendar" class="spotlight__cell">
	<p class="spotlight__cell__title">CALENDÁRIO</p>

	@php($week = [ 'domingo', 'segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado', 'N/A' ])
	@foreach($week as $day)
		<div class="calendar__label">{{ $day === 'N/A' ? '?' : $day }} <span>//</span></div>

		@foreach(\App\Models\Anime::where([ ['status', '=', 'Em lançamento'], ['airing_week_day', '=', $day] ])->orderBy('title', 'ASC')->get([ 'title', 'slug', 'cover', 'official_cover' ]) as $anime)
			<div class="spotlight__cell__content">
				<a class="spotlight__cell__link" href="{{ action('AnimeController@show', [ $anime->slug ]) }}" target="_self">
					<?php $cover = !empty($anime->official_cover) ? $anime->official_cover : $anime->cover ?>
					<img class="spotlight__cell__img" src="{{ !empty($cover) ? get_optimized_path($cover) : '/img/unknown.png' }}">

					<div class="spotlight__cell__description">
						{{ $anime->title }}
					</div>
				</a>
			</div>
		@endforeach
	@endforeach
</div>