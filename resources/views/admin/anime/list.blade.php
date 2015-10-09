@extends('master')

<?php $current_section = "Projetos" ?>

@section('content')
	<div style="position: absolute; right:16px; top: 24px">
		<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AdminController@showAnimeEditor', [ 'id' => 'novo' ]) }}'">
			<i class="material-icons">add</i>
		</button>
	</div>

	<h3>Projetos</h3>

	<table>
		@foreach($paginator = \App\Models\Anime::orderBy('updated_at', 'DESC')->paginate(10) as $anime)
			<tr>
				<td>
					{{ $anime->title }}
				</td>
				<td>
					<button id="anime-{{ $anime->id }}" class="mdl-button mdl-js-button mdl-button--icon" style="{{ empty($data->cover) ? 'margin-right: 126px' : '' }}">
						<i class="material-icons">more_vert</i>
					</button>

					<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="anime-{{ $anime->id }}">
						<a href="{!! URL::action('AdminController@showAnimeEditor', [ 'slug' => $anime->slug ]) !!}" target="_self" style="text-decoration: none"><li class="mdl-menu__item">Editar</li></a>
						<a href="{!! URL::action('AdminController@deleteAnimePrompt', [ 'slug' => $anime->slug ]) !!}" target="_self" style="text-decoration: none"><li class="mdl-menu__item">Remover</li></a>
					</ul>
				</td>
			</tr>
		@endforeach

		<tr>
			<td colspan="2">@include('pagination')</td>
		</tr>
	</table>
@endsection
