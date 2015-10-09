@extends('master')

<?php $current_section = "Episódios em massa" ?>

@section('content')
	{!! Form::open([ 'url' => 'admin/anime/'. $id .'/raw', 'style' => 'width:100%' ]) !!}
	<h3><span class="navigation-parent"><a class="navigation-parent-link" href="{!! URL::action('AnimeController@showAnimePage', [ 'slug' => $id ]) !!}" target="_self">{{ $name = \App\Models\Anime::find($id)->title }}</a> > </span> Adicionar episódios em massa</h3>

	<div class="mdl-textfield mdl-js-textfield" style="width:100%">
		<textarea class="mdl-textfield__input" rows="6" name="raw_text" required=""></textarea>
		<label class="mdl-textfield__label" for="raw_text">Texto...</label>
	</div>

	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
		Inserir
	</button>

	<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ URL::action('AdminController@showAnimeList') }}'" value="Cancelar">

	{!! Form::close() !!}

	<br>

	<h4>Intruções</h4>
	<p>A sintaxe para cada link é a seguinte.
	<pre>número episódio|link|qualidade|tamanho</pre>
	Exemplo:
	<pre>1|http://example.com|BD|500 MB</pre>
	Vai adicionar o download com link <i>http://example.com</i>, qualidade <i>BD</i> e tamanho <i>200 MB</i> ao episódio número <i>1</i> do anime <i>{{ $name }}</i>.
	</p>
	<p>
		Podem ser adicionados vários links de uma só vez. Ficando um link por linha.
		</p>
	<p>
		Exemplo:
	<pre>1|http://example.com/link1/bd|BD|500 MB
2|http://example.com/link2/hd|HD
2|http://example.com/link2/bd|BD|500 MB</pre>
	Neste exemplo, iremos adicionar o link da versão BD ao episódio 1 e os links da versão HD e BD ao episódio 2.
	<b>Nota: É possível omitir o valor do tamanho</b>
	</p>
@endsection