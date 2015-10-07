@extends('master')

<?php $current_section = "Editar " ($data->title ?? 'nova notícia') ?>

@section('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/redactor.css') }}">
@endsection

@section('content')
	{!! Form::open([ 'url' => 'admin/noticias/'. (isset($data) ? $data->id : 'novo'), 'files' => true, 'style' => 'width:100%' ]) !!}
	<h3>Notícias</h3>

	<div class="mdl-grid">
		<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--6-col">
			Título
			<input class="mdl-textfield__input" type="text" name="title" value="{{ old('title', $data->title ?? '')  }}" required="" />
			<label class="mdl-textfield__label" for="title"></label>
		</div>
	</div>

	{!! Form::textarea('text', $data->text ?? '', [ 'id' => 'text' ]) !!}

	<h4>Categoria</h4>

	@foreach(\App\Models\NewsCategory::all() as $category)
		<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="category-{{ $category->id }}">
			<input type="radio" id="category-{{ $category->id }}" class="mdl-radio__button" name="category" value="{{ $category->id }}" {{ (isset($data) ? $data->id_category : 1) == $category->id ? 'checked' : '' }} />
			<span class="mdl-radio__label">{{ $category->name }}</span>
		</label>
		<br>
	@endforeach

	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
		{{ isset($data) ? 'Atualizar' : 'Inserir' }}
	</button>

	<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ URL::action('AdminController@showNewsList') }}'" value="Cancelar">

	{!! Form::close() !!}


	<script type="text/javascript" src="{{ asset('js/redactor.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/redactor.fontcolor.js') }}"></script>

	<script>
		$(function() {
			$('#text').redactor({
				imageUpload: '/editor/upload',
				plugins: ['fontcolor']
			});
		});
	</script>
@endsection