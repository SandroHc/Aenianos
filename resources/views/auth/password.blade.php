@extends('master')

<?php $current_section = "Resetar password" ?>

@section('content')
	{!! Form::open([ 'url' => 'login/resetar', 'style' => 'margin:0 auto' ]) !!}

	<h3>Resetar password</h3>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="email" id="email" name="email" required="" value="{{ old('email') }}" />
		<label class="mdl-textfield__label" for="email">E-mail...</label>
	</div>

	<br>
	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
		Enviar pedido
	</button>

	{!! Form::close() !!}
@endsection