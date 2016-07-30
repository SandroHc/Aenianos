<div class="anime-header">
	<div class="anime-header__sub">
		<h1>{{ $data->title }} <span style="font-size: 28px; color: #969696; ">/ {{ $data->status }}</span></h1>

		<div style="width: 100%; background-color: rgba(150, 150, 150, 0.5); position: relative; ">
			@if(!empty($data->cover))
				<img src="/{{ $data->cover }}">
			@endif
			<div style="width: calc(100% - 280px); padding: 40px; color: #FFF; float: right;">
				{!! $data->synopsis !!}
			</div>

			@if(is_admin())
				<div style="position: absolute; right:0; bottom:-28px; z-index: 100">
					<button id="admin-add" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AdminController@showEpisodeEditor', [ 'id' => $data->id, 'type' => 'episodio', 'num' => 'novo' ]) }}'">
						<i class="material-icons">add</i>
					</button>
					<div class="mdl-tooltip" for="admin-add">Adicionar episódio</div>


					<button id="admin-edit" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AdminController@showAnimeEditor', [ 'slug' => $data->slug ]) }}'">
						<i class="material-icons">create</i>
					</button>
					<div class="mdl-tooltip" for="admin-edit">Editar</div>
				</div>
			@endif
		</div>
	</div>
</div>