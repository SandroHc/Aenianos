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
					<img src="/{{ get_optimized_path($data->official_cover) }}" id="show-modal-cover">
				@endif

				<span>
					@if($data->episodes != 0)
						<span class="mdl-chip">
							<span class="mdl-chip__text">{{ $data->episodes }} EPISÓDIOS</span>
						</span>
					@endif

					@if($data->premiered)
					<span class="mdl-chip">
						<span class="mdl-chip__text">{{ $data->premiered ?? '?' }}</span>
					</span>
					@endif

					@if($data->genres)
						<span class="mdl-chip">
							@foreach(explode(',', $data->genres) as $genre)
								<span class="mdl-chip__text mdl-chip__text--separator">{{ mb_strtoupper($genre) }}</span>
							@endforeach
						</span>
					@endif

					@if($data->studio || $data->website)
					<span class="mdl-chip mdl-chip--contact">
						<span class="mdl-chip__contact mdl-color--teal mdl-color-text--white"><i class="material-icons">language</i></span>
						<span class="mdl-chip__text"><a href="{!! $data->website ?? '#' !!}" target="_blank">{{ $data->studio ?? 'Site oficial' }}</a></span>
					</span>
					@endif

					@if($data->director)
					<span class="mdl-chip mdl-chip--contact">
						<span class="mdl-chip__contact mdl-color--teal mdl-color-text--white"><i class="material-icons">person</i></span>
						<span class="mdl-chip__text">{{ $data->director }}</span>
					</span>
					@endif
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
	<dialog id="modal-official-cover">
		<img data-src="{{ $data->official_cover }}">
	</dialog>
@endif