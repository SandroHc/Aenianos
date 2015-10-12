@extends('master')

<?php $current_section = "Registar" ?>

@section('content')
	{!! Form::open([ 'url' => URL::action('Auth\AuthController@postRegister'), 'style' => 'margin:0 auto' ]) !!}

	<h3>Registar</h3>

	@if(!$errors->isEmpty())
		@foreach($errors->all() as $error)
			<p>{{ $error }}</p>
		@endforeach
	@endif

	<div class="mdl-grid" style="width:50%; min-width: 300px">
		<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--6-col">
			Nome
			<input class="mdl-textfield__input" type="text" id="name" name="name" required="" value="{{ old('name') }}" />
			<label class="mdl-textfield__label" for="name"></label>
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--6-col">
			E-mail
			<input class="mdl-textfield__input" type="email" id="email" name="email" required="" value="{{ old('email') }}" />
			<label class="mdl-textfield__label" for="email"></label>
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--6-col">
			Password
			<input class="mdl-textfield__input" type="password" id="password" name="password" required="" />
			<label class="mdl-textfield__label" for="password"></label>
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--6-col">
			Confirmar password
			<input class="mdl-textfield__input" type="password" id="password_confirmation" name="password_confirmation" required="" />
			<label class="mdl-textfield__label" for="password_confirmation"></label>
		</div>

		<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-cell mdl-cell--6-col">
			Registar
		</button>
	</div>

	{!! Form::close() !!}
@endsection