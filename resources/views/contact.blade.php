@extends('master')

@section('title', 'Contato - Aenianos Fansub')

@section('content')
	{!! Form::open([ 'url' => 'contato', 'style' => 'margin:0 auto' ]) !!}
	<h3>Contato</h3>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="email" name="email" required="" />
		<label class="mdl-textfield__label" for="email">E-mail...</label>
	</div>

	<br>

	<div class="mdl-textfield mdl-js-textfield">
		<textarea class="mdl-textfield__input" rows="3" id="message" name="message" required=""></textarea>
		<label class="mdl-textfield__label" for="message">Mensagem...</label>
	</div>

	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
		Enviar
	</button>

	{!! Form::close() !!}
@endsection