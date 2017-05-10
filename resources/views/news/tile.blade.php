<div class="mdl-card mdl-shadow--2dp">
	<div class="mdl-card__title" style="padding-bottom:7px">
		<h2 class="mdl-card__title-text">
			@if(isset($show_comments))
				{{ $news->title }}
			@else
				<a href="{!! action('NewsController@show', [ $news->slug ]) !!}" target="_self">{{ $news->title }}</a>
			@endif
		</h2>

		@if(Auth::check())
			<button id="news-{{ $news->id }}" class="mdl-button mdl-js-button mdl-button--icon">
				<i class="material-icons">more_vert</i>
			</button>

			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="news-{{ $news->id }}">
				<a class="text-decoration--none" href="{{ action('NewsController@edit', [ $news->slug ]) }}" target="_self"><li class="mdl-menu__item">Editar</li></a>
				<a class="text-decoration--none" href="{{ action('NewsController@destroyWarning', [ $news->slug ]) }}" target="_self"><li class="mdl-menu__item">Remover</li></a>
			</ul>
		@endif
	</div>

	<div class="mdl-card__supporting-text mdl-card--no-padding">
		@php($category = $news->category)
		@php($now = \Carbon\Carbon::now())
		<span id="date-created-{{ $news->id }}">
			@if($news->created_at->year < $now->year) {{-- Show the year if not from the current one --}}
				{{ utf8_encode($news->created_at->formatLocalized('%A, %d %B, %Y')) }}
			@else
				@if($news->created_at->diff($now)->days < 1)
					<strong>{{ $news->updated_at->diffForHumans() }}</strong>
				@else
					{{ utf8_encode($news->created_at->formatLocalized('%A, %d de %B')) }}
				@endif
			@endif
		</span>
		@if($news->updated_at != $news->created_at)
			<div class="mdl-tooltip" for="date-created-{{ $news->id }}">
				editado
				@if($news->updated_by > 0)
					@if($user = \App\User::find($news->updated_by))
						por {{ $user->name }}
					@endif
				@endif
				<strong>{{ $news->updated_at->diffForHumans() }}</strong>
			</div>
		@endif
		@if($news->created_by > 0)
			@if($user = \App\User::find($news->created_by))
				por {{ $user->name }}
			@endif
		@endif
		em <a href="{!! action('NewsController@showNewsByCategory', [ 'slug' => $category->slug ]) !!}">{{ $category->name }}</a>
	</div>

	<div class="mdl-card__supporting-text mdl-card--no-padding">
		{!! $news->text !!}
	</div>

	@if(isset($show_comments))
		@include("disqus")
{{--
	@else
		<div style="position:absolute; right:16px; bottom:16px">
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{!! action('NewsController@showNewsPage', [ 'slug' => $data->slug ]) !!}'">
				<i class="material-icons">comment</i>
			</button>
		</div>
--}}
	@endif
</div>