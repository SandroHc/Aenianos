<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--8-col" style="margin: 15px auto">
	<div class="mdl-card__title" style="padding-bottom:7px">
		<h2 class="mdl-card__title-text">
			@if(isset($show_comments))
				{{ $data->title }}
			@else
				<a href="{!! action('NewsController@showDetailSlug', [ 'slug' => $data->slug ]) !!}" target="_self" style="text-decoration: none">{{ $data->title }}</a>
			@endif
		</h2>

		@if(Auth::check())
			<button id="news-{{ $data->id }}" class="mdl-button mdl-js-button mdl-button--icon">
				<i class="material-icons">more_vert</i>
			</button>

			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="news-{{ $data->id }}">
				<a href="{!! action('AdminController@showNewsEditor', [ 'id' => $data->id ]) !!}" target="_self" style="text-decoration: none"><li class="mdl-menu__item">Editar</li></a>
				<a href="{!! action('AdminController@deleteNewsPrompt', [ 'id' => $data->id ]) !!}" target="_self" style="text-decoration: none"><li class="mdl-menu__item">Remover</li></a>
			</ul>
		@endif
	</div>

	<div class="mdl-card__supporting-text mdl-card__width-fix">{{ ($category = \App\Models\NewsCategory::find($data->id_category)) ? '' : '' }}
		<span id="date-created-{{ $data->id }}">
			@if($data->created_at->year < \Carbon\Carbon::now()->year) {{-- Show the year if not from the current one --}}
				{{ utf8_encode($data->created_at->formatLocalized('%A, %d %B, %Y')) }}
			@else
				{{ utf8_encode($data->created_at->formatLocalized('%A, %d de %B')) }}
			@endif
		</span>
		@if($data->updated_at != $data->created_at)
			<div class="mdl-tooltip" for="date-created-{{ $data->id }}">
				editado pela última vez<br>{{ $data->updated_by > 0 ? 'por '. \App\User::find($data->updated_by)->name : '' }} <strong>{{ $data->updated_at->diffForHumans() }}</strong>
			</div>
		@endif
		@if($data->created_by > 0)
			por {{ \App\User::find($data->created_by)->name }}
		@endif
		em <a href="{!! action('NewsController@showCategoryListSlug', [ 'slug' => $category->slug ]) !!}">{{ $category->name }}</a>
	</div>

	<div class="mdl-card__supporting-text mdl-card__width-fix">
		{!! $data->text !!}
	</div>

	@if(isset($show_comments))
		<div id="disqus_thread"></div>
		<script type="text/javascript">
			(function() {
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true; dsq.src = '//aenianos.disqus.com/embed.js';
				document.getElementsByTagName('head')[0].appendChild(dsq);
			})();
		</script>
	@else
		<div style="position:absolute; right:16px; bottom:16px">
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{!! action('NewsController@showDetail', [ 'id' => $data->id ]) !!}'">
				<i class="material-icons">comment</i>
			</button>
		</div>
	@endif
</div>