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
			<div class="anime-header__sub__content__synopsis">
				@if(!empty($data->official_cover))
					{{--<div>--}}
					<img src="{{ $data->official_cover }}" id="show-modal-cover">
					{{--</div>--}}
				@endif

				<span style="color: white; display: inline">
					<span class="mdl-chip">
						<span class="mdl-chip__text">{{ $data->episodes != 0 ? $data->episodes : '?' }} EPISÓDIOS</span>
					</span>
					 |
					<span class="mdl-chip">
						<span class="mdl-chip__text">{{ $data->premiered ?? '?' }}</span>
					</span>
					 |
					@foreach(explode(',', $data->genres) as $genre)
						<span class="mdl-chip">
							<span class="mdl-chip__text">{{ $genre }}</span>
						</span>
					@endforeach
					 |
					<span class="mdl-chip mdl-chip--contact">
						<span class="mdl-chip__contact mdl-color--teal mdl-color-text--white"><i class="material-icons" style="line-height: 32px; margin-left: -1px">language</i></span>
						<span class="mdl-chip__text"><a href="{!! $data->website ?? '#' !!}" target="_blank">{{ $data->studio ?? '?' }}</a></span>
					</span>
				</span>

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

@if(!empty($data->official_cover))
	<dialog id="modal-official-cover" style="border: none; padding: 0; position: fixed; top: 50%; transform: translate(0, -50%);">
		<img src="{{ $data->official_cover }}" style="height: 80%; box-shadow: 0 9px 46px 8px rgba(0,0,0,.14),0 11px 15px -7px rgba(0,0,0,.12),0 24px 38px 3px rgba(0,0,0,.2)">
		<button id="close-modal-cover" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" style="background-color: #c51313; color: white; position: absolute; top: -10px; right: -10px;">
			<i class="material-icons">clear</i>
		</button>
	</dialog>
@endif