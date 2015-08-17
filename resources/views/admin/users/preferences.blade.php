@extends('master')

@section('title', 'Preferências - Aenianos Fansub')

@section('content')
	<h3>Perfil</h3>

	<h4>Dados gerais</h4>

	{!! Form::open([ 'url' => URL::action('UsersController@savePreferencesGeneral'), 'files' => true ]) !!}

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="name" name="name" required="" value="{{ $user->name }}" />
		<label class="mdl-textfield__label" for="name">Nome...</label>
	</div>

	<br>

	<h5>Avatar</h5>

	<p>
		<input type="file" name="avatar" />
	</p>

	@if(!empty($user->avatar))
		<img class="editor-capa" src="{{ $user->avatar }}">
	@endif

	<br>
	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
		Atualizar
	</button>

	{!! Form::close() !!}

	<h4>Alterar password</h4>

	{!! Form::open([ 'url' => URL::action('UsersController@savePreferencesPassword') ]) !!}

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="password" id="password" name="password" required="" />
		<label class="mdl-textfield__label" for="password">Password atual...</label>
	</div>

	<br>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="password" id="password_new" name="password_new" required="" />
		<label class="mdl-textfield__label" for="password_new">Nova password...</label>
	</div>

	<br>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="password" name="password_new_confirmation" required="" />
		<label class="mdl-textfield__label" for="password_new_confirmation">Confirmar password...</label>
	</div>

	<br>
	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
		Atualizar
	</button>

	{!! Form::close() !!}

	<h4>Alterar e-mail</h4>

	{!! Form::open([ 'url' => URL::action('UsersController@savePreferencesEmail') ]) !!}

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="email" id="email" name="email" required="" value="{{ $user->email }}" />
		<label class="mdl-textfield__label" for="name">E-mail...</label>
	</div>

	<br>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="email" id="email_new" name="email_new" required="" />
		<label class="mdl-textfield__label" for="email_new">Novo e-mail...</label>
	</div>

	<br>

	<br>
	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
		Atualizar
	</button>

	{!! Form::close() !!}
@endsection