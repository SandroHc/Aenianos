@extends('master')

<?php $current_section = "Login" ?>

@section('content')
	{!! Form::open([ 'url' => URL::action('Auth\AuthController@postLogin'), 'style' => 'margin:0 auto' ]) !!}

	<h3>Login</h3>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="email" id="email" name="email" required="" value="{{ old('email') }}" />
		<label class="mdl-textfield__label" for="email">E-mail...</label>
	</div>

	<br>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="password" id="password" name="password" required="" />
		<label class="mdl-textfield__label" for="password">Password...</label>
	</div>

	<br>

	<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="remember">
		<input type="checkbox" id="remember" name="remember" class="mdl-checkbox__input" checked />
		<span class="mdl-checkbox__label">Lembrar-me</span>
	</label>

	<br>
	<br>

	<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ url('/login/resetar') }}'" value="Esqueci-me da password">

	<br>
	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
		Entrar
	</button>

	{!! Form::close() !!}
@endsection