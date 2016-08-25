@extends('master')

@section('title', 'Login')

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp mdl-cell mdl-cell--8-col">

		<div class="mdl-card__supporting-text mdl-card--no-padding">

			{!! Form::open([ 'url' => URL::action('Auth\AuthController@postLogin'), 'style' => 'margin:0 auto' ]) !!}

			<h3>Login</h3>

			@if(!$errors->isEmpty())
				@foreach($errors->all() as $error)
					<p>{{ $error }}</p>
				@endforeach
			@endif

			<div class="login__field mdl-grid">
				<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--12-col">
					E-mail
					<input class="mdl-textfield__input" type="email" id="email" name="email" required="" value="{{ old('email') }}" />
					<label class="mdl-textfield__label" for="email"></label>
				</div>

				<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--12-col">
					Password
					<input class="mdl-textfield__input" type="password" id="password" name="password" required="" />
					<label class="mdl-textfield__label" for="password"></label>
				</div>

				<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect mdl-cell mdl-cell--12-col" for="remember">
					<input type="checkbox" id="remember" name="remember" class="mdl-checkbox__input" checked />
					<span class="mdl-checkbox__label">Lembrar-me</span>
				</label>

				<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-cell mdl-cell--6-col">
					Entrar
				</button>

				<input type="button" class="mdl-button mdl-js-button mdl-cell mdl-cell--6-col" onclick="window.location='{{ url('/login/resetar') }}'" value="Esqueci-me da password">
			</div>

			{!! Form::close() !!}

		</div>
	</div>
@endsection