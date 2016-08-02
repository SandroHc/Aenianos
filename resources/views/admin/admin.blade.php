@extends('master')

@section('title', 'Administração - Aenianos Fansub')

@section('content')
	<div class="mdl-card mdl-grid mdl-shadow--2dp">
		<div class="mdl-cell mdl-cell--8-col">
			{{ $numAnime = \App\Models\Anime::count() }} projetos<br>
			{{ $numEps = \App\Models\Episode::count() }} episódios ({{ $numEps / $numAnime }} por projeto)<br>
			{{ \App\Models\Episode::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count() }} episódios lançados no último mês
		</div>
		<div class="mdl-cell mdl-cell--3-col">
			<a href="/anime">Gerir Projetos</a>
		</div>
		<div class="mdl-cell mdl-cell--1-col">
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AnimeController@add') }}'">
				<i class="material-icons">add</i>
			</button>
		</div>
	</div>

	<div class="mdl-card mdl-grid mdl-shadow--2dp">
		<div class="mdl-cell mdl-cell--8-col">
			{{ \App\Models\News::count() }} notícias<br>
			{{ \App\Models\News::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count() }} no último mês
		</div>
		<div class="mdl-cell mdl-cell--3-col">
			<a href="{{ URL::action('NewsController@list') }}">Gerir Notícias</a>
			<br>
			<a href="">Gerir Categorias</a>
		</div>
		<div class="mdl-cell mdl-cell--1-col">
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('NewsController@add') }}'">
				<i class="material-icons">add</i>
			</button>
		</div>
	</div>

	<div class="mdl-card mdl-grid mdl-shadow--2dp">
		<div class="mdl-cell mdl-cell--8-col">
			{{ \App\User::count() }} utilizadores ativos<br>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<a href="{{ URL::action('UsersController@list') }}">Gerir Utilizadores</a>
			<br>
			<a href="{{ URL::action('UsersController@preferences') }}">Editar Perfil</a>
		</div>
	</div>
@endsection