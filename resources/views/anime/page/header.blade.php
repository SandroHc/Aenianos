<div class="anime-header">
	<div class="anime-header__sub">
		<h1>
			{{ $anime->title }}
			<span style="font-size: 0.5em; color: #969696; ">
				@if($anime->japanese != $anime->title)
					{{ $anime->japanese }}
				@endif

				@if($anime->status != 'Concluído')
					/ {{ $anime->status }}
				@endif
			</span>
		</h1>

		<div class="anime-header__sub__content">
			<div class="anime-header__sub__content__synopsis">
				@if(!empty($anime->official_cover))
					<img src="/{{ get_optimized_path($anime->official_cover) }}" id="show-modal-cover">
				@endif

				<span>
					@if($anime->episodes != 0)
						<span class="mdl-chip">
							<span class="mdl-chip__text">{{ $anime->episodes }} EPISÓDIOS</span>
						</span>
					@endif

					@if($anime->premiered)
					<span class="mdl-chip">
						<span class="mdl-chip__text">{{ $anime->premiered ?? '?' }}</span>
					</span>
					@endif

					@if($anime->genres)
						<span class="mdl-chip">
							@foreach(explode(',', $anime->genres) as $genre)
								<span class="mdl-chip__text mdl-chip__text--separator">{{ mb_strtoupper($genre) }}</span>
							@endforeach
						</span>
					@endif

					@if($anime->studio || $anime->website)
					<span class="mdl-chip mdl-chip--contact">
						<span class="mdl-chip__contact mdl-color--teal mdl-color-text--white"><i class="material-icons">language</i></span>
						<span class="mdl-chip__text"><a href="{{ $anime->website ?? '#' }}" target="_blank">{{ $anime->studio ?? 'Site oficial' }}</a></span>
					</span>
					@endif

					@if($anime->director)
					<span class="mdl-chip mdl-chip--contact">
						<span class="mdl-chip__contact mdl-color--teal mdl-color-text--white"><i class="material-icons">person</i></span>
						<span class="mdl-chip__text">{{ $anime->director }}</span>
					</span>
					@endif
				</span>

				{!! $anime->synopsis !!}

				@if(is_admin())
					<div style="position: absolute; right:0; top:-28px; z-index: 100">
						<button id="admin-add" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ action('EpisodeController@add', [ 'anime' => $anime->slug, 'type' => 'episode' ]) }}'">
							<i class="material-icons">add</i>
						</button>
						<div class="mdl-tooltip" for="admin-add">Adicionar episódio</div>


						<button id="admin-edit" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ action('AnimeController@edit', [ $anime->slug ]) }}'">
							<i class="material-icons">create</i>
						</button>
						<div class="mdl-tooltip" for="admin-edit">Editar</div>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>

@if(!empty($anime->official_cover))
	<dialog id="modal-official-cover">
		<img data-src="{{ $anime->official_cover }}">
	</dialog>
@endif