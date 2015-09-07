<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="O Aenianos é um fansubber brasileiro de anime">
	<meta name="keywords" content="aenianos,fansub,pt,br,séries,animes,filmes">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield("title")</title>

	<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />

	{{-- Import some external libraries. --}}
	{{-- Material Design Lite - http://getmdl.io --}}
	{{-- jQuery - https://jquery.com --}}
	@if(Config::get('app.debug') == true)
		<link rel="stylesheet" href="{{ asset('dev-env/material.blue-indigo.min.css') }}">
		<script src="{{ asset('dev-env/material.min.js') }}"></script>

		<script src="{{ asset('dev-env/jquery.min.js') }}"></script>
	@else
		<link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.0.1/material.blue-indigo.min.css">
		<script src="https://storage.googleapis.com/code.getmdl.io/1.0.1/material.min.js"></script>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	@endif

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	{{-- Minified CSS for the whole app --}}
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

	@yield("head")
</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--overlay-drawer-button">
	<header class="mdl-layout__header mdl-layout__header--waterfall">
		<!-- Top row, always visible -->
		<div class="mdl-layout__header-row">
			<!-- Title -->
			<span class="mdl-layout-title">Aenianos Fansub</span>
			<div class="mdl-layout-spacer"></div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable
                  mdl-textfield--floating-label mdl-textfield--align-right">
				<label class="mdl-button mdl-js-button mdl-button--icon"
					   for="waterfall-exp">
					<i class="material-icons">search</i>
				</label>
				<div class="mdl-textfield__expandable-holder">
					{!! Form::open([ 'url' => 'procurar' ]) !!}

					<input class="mdl-textfield__input" type="text" name="search" id="waterfall-exp" />

					{!! Form::close() !!}
				</div>
			</div>
		</div>
		<!-- Bottom row, not visible on scroll -->
		<div class="mdl-layout__header-row">
			<div class="mdl-layout-spacer"></div>
			<!-- Navigation -->
			<nav class="waterfall-demo-header-nav mdl-navigation navigation-header">
				<a class="link-home mdl-navigation__link" href="/">Home</a>
				<a class="link-projetos mdl-navigation__link" href="/anime">Projetos</a>
				@if(Auth::check())
					<a class="link-contacto mdl-navigation__link" href="/admin">Administração</a>
				@endif
			</nav>
		</div>
	</header>
	<div class="mdl-layout__drawer">
		<span class="mdl-layout-title">Aenianos</span>
		<nav class="mdl-navigation drawer-navigation">
			<a class="mdl-navigation__link" href="/">Home</a>
			<a class="mdl-navigation__link" href="/anime">Projetos</a>
			<a class="mdl-navigation__link" href="/sobre">Sobre</a>
			<a class="mdl-navigation__link" href="/faq">FAQ</a>
			<a class="mdl-navigation__link" href="/doacoes">Doações</a>
			<a class="mdl-navigation__link" href="/contato">Contato</a>
			<div class="mdl-layout-spacer"></div>
			@if(Auth::check())
				<a class="mdl-navigation__link" href="/admin">Administração</a>
				<a class="mdl-navigation__link" href="/logout">Sair</a>
			@else
				<a class="mdl-navigation__link" href="/login">Login</a>
			@endif
		</nav>
	</div>
	<main class="mdl-layout__content">
		<div class="page-content">
			@yield('content-before')

			<div class="mdl-grid mdl-grid-wide">
				@yield('content')
			</div>
		</div>
	</main>
</div>

<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	@if(Auth::check())
	ga('set', '&uid', '{{ Auth::id() }}');
	@endif
	ga('create', 'UA-65616234-1', 'auto');
	ga('send', 'pageview');
</script>

</body>
</html>