@extends('master')

@section('title', 'Preferências')

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp mdl-cell mdl-cell--8-col">

		<div class="mdl-card__supporting-text mdl-card--no-padding">

			<h3>Perfil</h3>

			<h4>Dados gerais</h4>

			{!! Form::open([ 'url' => URL::action('UserController'), 'files' => true ]) !!}

			<div class="mdl-textfield mdl-js-textfield">
				Nickname
				<input class="mdl-textfield__input" type="text" id="name" name="name" required="" value="{{ $user->name }}" />
				<label class="mdl-textfield__label" for="name"></label>
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

			{!! Form::open([ 'url' => URL::action('UserController') ]) !!}

			<div class="mdl-textfield mdl-js-textfield">
				Password atual
				<input class="mdl-textfield__input" type="password" id="password" name="password" required="" />
				<label class="mdl-textfield__label" for="password"></label>
			</div>

			<br>

			<div class="mdl-textfield mdl-js-textfield">
				Nova password
				<input class="mdl-textfield__input" type="password" id="password_new" name="password_new" required="" />
				<label class="mdl-textfield__label" for="password_new"></label>
			</div>

			<br>

			<div class="mdl-textfield mdl-js-textfield">
				Confirmar password
				<input class="mdl-textfield__input" type="password" name="password_new_confirmation" required="" />
				<label class="mdl-textfield__label" for="password_new_confirmation"></label>
			</div>

			<br>
			<br>

			<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
				Atualizar
			</button>

			{!! Form::close() !!}

			<h4>Alterar e-mail</h4>

			{!! Form::open([ 'url' => URL::action('UserController') ]) !!}

			<div class="mdl-textfield mdl-js-textfield">
				Password atual
				<input class="mdl-textfield__input" type="password" id="password" name="password" required="" />
				<label class="mdl-textfield__label" for="password"></label>
			</div>

			<br>

			<div class="mdl-textfield mdl-js-textfield">
				E-mail
				<input class="mdl-textfield__input" type="email" id="email" name="email" required="" value="{{ $user->email }}" />
				<label class="mdl-textfield__label" for="name"></label>
			</div>

			<br>

			<br>
			<br>

			<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
				Atualizar
			</button>

			{!! Form::close() !!}

		</div>
	</div>
@endsection