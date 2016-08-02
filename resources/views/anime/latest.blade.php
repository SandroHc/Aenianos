<div id="rencent" class="spotlight__cell">
	<p class="spotlight__cell__title">LANÇAMENTOS RECENTES</p>

	@foreach(\App\Models\Episode::getLatest() as $data)
		<?php $anime = $data->_anime()->first() ?>
		<div class="spotlight__cell__content">
			<a class="spotlight__cell__link" href="{!! URL::action('AnimeController@page', [ 'slug' => $anime->slug ]) !!}" target="_self">
				<?php $cover = !empty($anime->official_cover) ? $anime->official_cover : $anime->cover ?>
				<img class="spotlight__cell__img" src="{{ !empty($cover) ? get_optimized_path($cover) : '/img/unknown.png' }}">

				<div class="spotlight__cell__description">
					{{ $anime->title }}<br>

					<div class="spotlight__cell__episode">
						{{ $data->type }} {{ $data->num }}
					</div>
				</div>
			</a>
		</div>
	@endforeach
</div>