@extends('master')

@section('title', 'Erro de validação')

@section('content')
	<h3>Ocorreu um erro ao validar o formulário</h3>

	<div class="mdl-grid" style="width:100%">
		<div class="mdl-cell mdl-cell--12-col">
			<p>Erros:
			<ul>
				@foreach($validation->all('<li>:message</li>') as $message)
					{!! $message !!}
				@endforeach
			</ul>
			</p>
		</div>
		<div class="mdl-cell mdl-cell--12-col">
			<a href="{{ URL::previous() }}" target="_self">Voltar</a>
		</div>
	</div>
@endsection