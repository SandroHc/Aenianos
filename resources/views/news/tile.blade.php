<div class="mdl-card mdl-shadow--2dp">
	<div class="mdl-card__title" style="padding-bottom:7px">
		<h2 class="mdl-card__title-text">
			@if(isset($show_comments))
				{{ $data->title }}
			@else
				<a class="text-decoration--none" href="{!! action('NewsController@page', [ 'slug' => $data->slug ]) !!}" target="_self">{{ $data->title }}</a>
			@endif
		</h2>

		@if(Auth::check())
			<button id="news-{{ $data->id }}" class="mdl-button mdl-js-button mdl-button--icon">
				<i class="material-icons">more_vert</i>
			</button>

			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="news-{{ $data->id }}">
				<a class="text-decoration--none" href="{!! action('NewsController@manage', [ 'slug' => $data->slug ]) !!}" target="_self"><li class="mdl-menu__item">Editar</li></a>
				<a class="text-decoration--none" href="{!! action('NewsController@deleteWarning', [ 'slug' => $data->slug ]) !!}" target="_self"><li class="mdl-menu__item">Remover</li></a>
			</ul>
		@endif
	</div>

	<div class="mdl-card__supporting-text mdl-card--no-padding">
		<?php $category = \App\Models\NewsCategory::find($data->id_category); ?>
		<span id="date-created-{{ $data->id }}">
			@if($data->created_at->year < \Carbon\Carbon::now()->year) {{-- Show the year if not from the current one --}}
				{{ utf8_encode($data->created_at->formatLocalized('%A, %d %B, %Y')) }}
			@else
				{{ utf8_encode($data->created_at->formatLocalized('%A, %d de %B')) }}
			@endif
		</span>
		@if($data->updated_at != $data->created_at)
			<div class="mdl-tooltip" for="date-created-{{ $data->id }}">
				editado
				@if($data->updated_by > 0)
					@if($user = \App\User::find($data->updated_by))
						por {{ $user->name }}
					@endif
				@endif
				<strong>{{ $data->updated_at->diffForHumans() }}</strong>
			</div>
		@endif
		@if($data->created_by > 0)
			@if($user = \App\User::find($data->created_by))
				por {{ $user->name }}
			@endif
		@endif
		em <a href="{!! action('NewsController@showNewsByCategory', [ 'slug' => $category->slug ]) !!}">{{ $category->name }}</a>
	</div>

	<div class="mdl-card__supporting-text mdl-card--no-padding">
		{!! $data->text !!}
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