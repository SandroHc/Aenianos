@extends('master')

@section('title')
	Editar {{ isset($data) ? (($data->num > 0 ? '#'. $data->num : 'Outro') .' '. $data->title) : 'novo episódio' }} - Aenianos Fansub
@endsection

@section('content')
	{!! Form::open([ 'url' => 'admin/anime/'. $id .'/'. $type .'/'. (isset($num) ? $num : 'novo'), 'style' => 'width:100%' ]) !!}
	<h3><span class="navigation-parent"><a class="navigation-parent-link" href="{!! URL::action('AnimeController@showDetail', [ 'id' => $id ]) !!}" target="_self">{{ \App\Models\Anime::find($id)->title }}</a> > </span> {{ isset($data) ? (($data->num > 0 ? '#'. $data->num : 'Outro') .' '. $data->title) : 'Novo' }}</h3>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" name="num" value="{{ isset($data) ? $data->num : ($num != 'novo' ? $num : (($ep_num = \App\Models\Episode::where('anime_id', '=', $id)->orderBy('num', 'DESC')->first()) != NULL ? $ep_num->num + 1 : 1)) }}" />
		<label class="mdl-textfield__label" for="num">#</label>
		<span class="mdl-textfield__error">Insira um número válido!</span>
	</div>

	<div class="mdl-textfield" style="padding-left: 20px">
		<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="torrent" alt="Não é possível alterar esta propriedade em episódios guardados. Elimine este episódio caso necessário.">
			<input type="checkbox" id="torrent" name="torrent" class="mdl-checkbox__input" {{ isset($data) ? 'disabled' : '' }} {{ $num === '0' ? 'checked' : '' }} />
			<span class="mdl-checkbox__label">Torrent?</span>
		</label>
	</div>

	<br>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" name="title" value="{{ isset($data) ? $data->title : '' }}" />
		<label class="mdl-textfield__label" for="titulo">Título...</label>
	</div>

	<br>

	<h5>Tipo</h5>

	<?php $values = [ [ 'value' => 'episodio', 'visible' => 'Série'], [ 'value' => 'filme', 'visible' => 'Filme' ], [ 'value' => 'especial', 'visible' => 'Especial' ] ]; ?>
	@foreach($values as $cur)
		<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="type-{{ $cur['value'] }}">
			<input type="radio" id="type-{{ $cur['value'] }}" class="mdl-radio__button" name="type" value="{{ $cur['value'] }}" {{ (!isset($data) && $values[0]['value'] === $cur['value']) || (isset($data) && $data->type === $cur['value']) ? 'checked' : '' }} />
			<span class="mdl-radio__label">{{ $cur['visible'] }}</span>
		</label>
		<br>
	@endforeach

	<br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
		{{ isset($data) ? 'Atualizar' : 'Inserir' }}
	</button>

	<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ URL::action('AdminController@showAnimeList') }}'" value="Cancelar">

	{!! Form::close() !!}

	<br>

	<h4>Downloads</h4>
	@if(isset($data))
		<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
			<thead>
			<tr>
				<th class="mdl-data-table__cell--non-numeric" colspan="2">Nome</th>
				<th class="mdl-data-table__cell--non-numeric">Link</th>
				<th class="mdl-data-table__cell--non-numeric">Qualidade</th>
				<th class="mdl-data-table__cell--non-numeric">Tamanho</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			@foreach(\App\Models\Download::getList($data->id) as $download)
			<tr>
				<td style="padding-right:0"><img src="http://www.google.com/s2/favicons?domain={{ $download->host_link }}" class="download-link-icon"></td>
				<td class="mdl-data-table__cell--non-numeric">{{ $download->host_name }}</td>
				<td class="mdl-data-table__cell--non-numeric"><a href="{{ $download->host_link }}" target="_blank">{{ $download->host_link }}</a></td>
				<td class="mdl-data-table__cell--non-numeric">{{ $download->quality }}</td>
				<td class="mdl-data-table__cell--non-numeric">{{ $download->size }}</td>
				<td>
					{!! Form::open([ 'url' => 'admin/anime/'. $id .'/episodio/'. $num, 'method' => 'delete', 'style' => 'width:100%' ]) !!}

					<input type="hidden" name="download_id" value="{{ $download->id }}">

					<button type="submit"  class="mdl-button mdl-js-button mdl-button--icon">
						<i class="material-icons">delete</i>
					</button>

					{!! Form::close() !!}
				</td>
			</tr>
			@endforeach

			{!! Form::open([ 'url' => 'admin/anime/'. $id .'/'. $type .'/'. $num, 'method' => 'put', 'style' => 'width:100%' ]) !!}

			<tr>
				<td class="mdl-data-table__cell--non-numeric" colspan="2"><i>Automático</i></td>
				<td class="mdl-data-table__cell--non-numeric">
					<div class="mdl-textfield mdl-js-textfield" style="margin-top:-20px; padding-bottom:0">
						<input class="mdl-textfield__input" type="text" name="host_link" value="{{ old('host_link') }}" />
						<label class="mdl-textfield__label" for="host_link">Link...</label>
					</div>
				</td>
				<td class="mdl-data-table__cell--non-numeric">
					<select name="quality">
						<option value="BD" selected>BD</option>
						<option value="HD">HD</option>
						<option value="SD">SD</option>
					</select>
				</td>
				<td class="mdl-data-table__cell--non-numeric">
					<div class="mdl-textfield mdl-js-textfield" style="margin-top:-20px; padding-bottom:0; width:70px">
						<input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" name="size" value="{{ old('size') }}" />
						<label class="mdl-textfield__label" for="tamanho">#</label>
					</div>
					<select name="size-suffix">
						<option value="MB" selected>MB</option>
						<option value="GB">GB</option>
					</select>
				</td>
				<td>
					<button type="submit" class="mdl-button mdl-js-button mdl-button--icon">
						<i class="material-icons">done</i>
					</button>
				</td>
			</tr>

			{!! Form::close() !!}
			</tbody>
		</table>
	@else
		<p>Guarde o episódio antes de adicionar links de download.</p>
	@endif
@endsection