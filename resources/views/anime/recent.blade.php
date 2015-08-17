<div id="spotlight">
	@foreach(\App\Models\Episode::getLatestEpisodes() as $data)
		<div class="spotlight-content">
			<a class="spotlight-link" href="{!! URL::action('AnimeController@showDetailSlug', [ 'slug' => $data->slug ]) !!}" target="_self">
				<img class="spotlight-img" src="{{ !empty($data->official_cover) ? $data->official_cover : (!empty($data->cover) ? $data->cover : '/img/unknown.png') }}">

				<div class="spotlight-description">
					{{ \App\Util::trim($data->title, 20) }}
				</div>
			</a>
		</div>
	@endforeach
</div>