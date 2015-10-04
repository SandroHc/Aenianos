@extends('master')

@section('title', 'Registar - Aenianos Fansub')

@section('content')
	{!! Form::open([ 'url' => URL::action('Auth\AuthController@postRegister'), 'style' => 'margin:0 auto' ]) !!}

	<h3>Registar</h3>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="name" name="name" required="" value="{{ old('name') }}" />
		<label class="mdl-textfield__label" for="name">Nome...</label>
	</div>

	<br>

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
		<label class="mdl-textfield__label" for="password_confirmation">Confirmar password...</label>
	</div>

	<br>
	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
		Registar
	</button>

	{!! Form::close() !!}
@endsection