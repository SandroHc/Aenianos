@extends('master')

@section('title', 'Administração - Aenianos Fansub')

@section('content')
	<div class="mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
		<div class="mdl-cell mdl-cell--8-col">
			{{ $numAnime = \App\Models\Anime::count() }} projetos<br>
			{{ $numEps = \App\Models\Episode::count() }} episódios ({{ $numEps / $numAnime }} por projeto)<br>
			{{ \App\Models\Episode::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count() }} episódios lançados no último mês
		</div>
		<div class="mdl-cell mdl-cell--3-col">
			<a href="{{ URL::action('AdminController@showAnimeList') }}">Gerir Projetos</a>
		</div>
		<div class="mdl-cell mdl-cell--1-col">
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AdminController@showAnimeEditor', [ 'id' => 'novo' ]) }}'">
				<i class="material-icons">add</i>
			</button>
		</div>
	</div>

	<div class="mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
		<div class="mdl-cell mdl-cell--8-col">
			{{ \App\Models\News::count() }} notícias<br>
			{{ \App\Models\News::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count() }} no último mês
		</div>
		<div class="mdl-cell mdl-cell--3-col">
			<a href="{{ URL::action('AdminController@showNewsList') }}">Gerir Notícias</a>
			<br>
			<a href="">Gerir Categorias</a>
		</div>
		<div class="mdl-cell mdl-cell--1-col">
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AdminController@showNewsEditor', [ 'id' => 'novo' ]) }}'">
				<i class="material-icons">add</i>
			</button>
		</div>
	</div>

	<div class="mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
		<div class="mdl-cell mdl-cell--8-col">
			{{ \App\User::count() }} utilizadores ativos<br>
		</div>
		<div class="mdl-cell mdl-cell--3-col">
			<a href="{{ URL::action('UsersController@showUsersList') }}">Gerir Utilizadores</a>
			<br>
			<a href="{{ URL::action('UsersController@showPreferences') }}">Editar Perfil</a>
		</div>
		<div class="mdl-cell mdl-cell--1-col">
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('Auth\AuthController@getRegister') }}'">
				<i class="material-icons">add</i>
			</button>
		</div>
	</div>
@endsection