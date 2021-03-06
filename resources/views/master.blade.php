@php($debug = Config::get('app.production') == false)
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="O Aenianos é um fansubber brasileiro de anime">
	<meta name="keywords" content="aenianos,fansub,pt,br,séries,animes,filmes,mahou shoujo">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		@if(isset($title))
			{{ $title }}
		@else
			@hasSection('title')
				@yield('title') /
			@endif
			{{ env('APP_NAME', 'Aenianos') }}
		@endif
	</title>

	<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
	<link rel="manifest" href="{{ asset('manifest.json') }}">

	{{-------- CSS --------}}
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	{{-- Material Design Lite - http://getmdl.io --}}
	<link rel="stylesheet" href="{{ $debug ? asset('dev-env/material.blue-indigo.min.css') : 'https://storage.googleapis.com/code.getmdl.io/1.2.0/material.blue-indigo.min.css' }}">

	{{-- Minified CSS for the whole app --}}
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

	@yield("head")


	{{------ SCRIPTS ------}}

	{{-- Import some external libraries. --}}
	<script src="{{ $debug ? asset('dev-env/jquery.min.js') : 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js' }}"></script>
	{{--<script src="{{ $debug ? asset('dev-env/turbolinks.js') : 'https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.0.0/turbolinks.min.js' }}" async></script>--}}
	<script src="{{ $debug ? asset('dev-env/material.min.js') : 'https://storage.googleapis.com/code.getmdl.io/1.2.0/material.min.js' }}" async></script>

	<script src="{{ asset('js/build/app.js') }}"></script>

	@if(Auth::check())
		<script defer>
			var uid = '{{ Auth::id() }}';
		</script>
	@endif
	<script src="{{ asset('js/analytics.js') }}" defer async></script>

	@stack('scripts')
</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--overlay-drawer-button">
	<header class="mdl-layout__header mdl-layout__header--waterfall">
		{{-- Top row, always visible --}}
		<div class="mdl-layout__header-row">
			{{-- Title --}}
			<span class="mdl-layout-title"><a class="text-decoration--none" href="{{ action('GeneralController@home') }}">{{ env('APP_NAME', 'Aenianos') }}</a></span>
			<div class="mdl-layout-spacer"></div>

			{{-- Navigation --}}
			<div class="navigation__container">
				<nav class="mdl-navigation navigation mdl-cell--hide-phone mdl-cell--hide-tablet">
					<a class="mdl-navigation__link mdl-typography--text-uppercase" href="{{ action('GeneralController@home') }}">Home</a>
					<a class="mdl-navigation__link mdl-typography--text-uppercase" href="{{ action('AnimeController@index') }}">Projetos</a>

					@if(is_admin())
						<a class="mdl-navigation__link mdl-typography--text-uppercase" href="{{ action('AdminController@index') }}">Administração</a>
					@endif
				</nav>
			</div>

			{{-- Search --}}
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right header__search">
				<label class="mdl-button mdl-js-button mdl-button--icon" for="waterfall-exp">
					<i class="material-icons">search</i>
				</label>
				<div class="mdl-textfield__expandable-holder">
					{!! Form::open([ 'url' => 'procurar' ]) !!}

					<input class="mdl-textfield__input" type="text" name="search" id="waterfall-exp" />

					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</header>
	<div class="mdl-layout__drawer">
		<span class="mdl-layout-title">Aenianos</span>
		<nav class="mdl-navigation drawer-navigation">
			<a class="mdl-navigation__link" href="{{ action('GeneralController@home') }}">Home</a>
			<a class="mdl-navigation__link" href="{{ action('AnimeController@index') }}">Projetos</a>
			<a class="mdl-navigation__link" href="{{ action('GeneralController@about') }}">Sobre</a>
			<a class="mdl-navigation__link" href="{{ action('GeneralController@faq') }}">FAQ</a>
			<a class="mdl-navigation__link" href="{{ action('GeneralController@donations') }}">Doações</a>
			<a class="mdl-navigation__link" href="{{ action('GeneralController@contact') }}">Contato</a>
			<div class="mdl-layout-spacer"></div>
			<?php $user = Auth::user() ?>
			@if($user !== NULL)
				@if($user->admin)
					<a class="mdl-navigation__link" href="{{ action('AdminController@index') }}">Administração</a>
				@endif
				<a class="mdl-navigation__link" href="/logout">Sair</a>
			@else
				<a class="mdl-navigation__link" href="/login">Login</a>
				<a class="mdl-navigation__link" href="/registar">Registar</a>
			@endif
		</nav>
	</div>
	<main class="mdl-layout__content">
		@yield('content-before')

		<div class="mdl-grid mdl-grid--wide">
			@yield('content')
		</div>
	</main>
</div>

</body>
</html>