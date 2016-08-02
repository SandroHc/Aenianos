<div class="anime-header">
	<div class="anime-header__sub">
		<h1>
			{{ $data->title }}
			<span style="font-size: 0.5em; color: #969696; ">
				@if($data->japanese != $data->title)
					{{ $data->japanese }}
				@endif

				@if($data->status != 'Concluído')
					/ {{ $data->status }}
				@endif
			</span>
		</h1>

		<div class="anime-header__sub__content">
			@if(!empty($data->official_cover))
				<div>
					<img src="/{{ $data->official_cover }}">
				</div>
			@endif
			<div class="anime-header__sub__content__synopsis">
				<span style="font-size: 1.4em; font-weight: bold; display: inline-block; margin-bottom: 20px">{{ $data->episodes != 0 ? $data->episodes : '?' }} EPISÓDIOS | {{ $data->premiered ?? '?' }} | {{ !empty($data->genres) ? $data->genres : '?' }} | <a href="{!! $data->website ?? '#' !!}" target="_blank">{{ $data->studio ?? '?' }}</a></span>

				{!! $data->synopsis !!}

				@if(is_admin())
					<div style="position: absolute; right:0; top:-28px; z-index: 100">
						<button id="admin-add" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AnimeController@manage', [ 'slug' => $data->slug ]) }}'">
							<i class="material-icons">add</i>
						</button>
						<div class="mdl-tooltip" for="admin-add">Adicionar episódio</div>


						<button id="admin-edit" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AnimeController@manage', [ 'slug' => $data->slug ]) }}'">
							<i class="material-icons">create</i>
						</button>
						<div class="mdl-tooltip" for="admin-edit">Editar</div>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>