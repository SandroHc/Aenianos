@extends('master')

<?php $current_section = "Resetar password" ?>

@section('content')
	{!! Form::open([ 'url' => 'login/novapassword', 'style' => 'margin:0 auto' ]) !!}

	<input type="hidden" name="token" value="{{ $token }}">

	<h3>Resetar password</h3>

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

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="password" id="password_confirmation" name="password_confirmation" required="" />
		<label class="mdl-textfield__label" for="password">Confirmar password...</label>
	</div>

	<br>
	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
		Resetar
	</button>

	{!! Form::close() !!}
@endsection