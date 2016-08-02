@extends('master')

<?php $data = $data[0]; ?>
<?php $current_section = 'Editar #' . $data->num ?>

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp mdl-cell mdl-cell--8-col">

		<div class="mdl-card__supporting-text mdl-card--no-padding">

			{!! Form::open([ 'url' => URL::action('EpisodeController@update', [ 'slug' => $data->anime, 'type' => $data->type, 'num' => $data->num ]), 'style' => 'width:100%' ]) !!}
			<h3><span class="navigation-parent"><a class="navigation-parent-link" href="{!! URL::action('AnimeController@page', [ 'slug' => $data->anime ]) !!}" target="_self">{{ $data->_anime->title }}</a> > </span> #{{ $data->num }}</h3>

			@if(!$errors->isEmpty())
				@foreach($errors->all() as $error)
					<p>{{ $error }}</p>
				@endforeach
			@endif



			<br>

			<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
				Atualizar
			</button>

			<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ URL::action('AnimeController@manage', [ 'slug' => $data->anime ]) }}'" value="Cancelar">

			{!! Form::close() !!}

			<br>

			<h4>Downloads</h4>

			<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
				<thead>
				<tr>
					<th class="mdl-data-table__cell--non-numeric" colspan="3">Link</th>
					<th class="mdl-data-table__cell--non-numeric">Qualidade</th>
					<th class="mdl-data-table__cell--non-numeric">Tamanho</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($data->downloads as $download)
				<tr>
					<?php $host = $download->host; ?>
					<td style="padding-right:0"><img src="{{ $host->icon ?? '/img/unknown_circle.png' }}" class="download-link-icon"></td>
					<td class="mdl-data-table__cell--non-numeric">{{ $host->name ?? '?' }}</td>
					<td class="mdl-data-table__cell--non-numeric"><a href="{{ $download->link }}" target="_blank">{{ $download->link }}</a></td>
					<td class="mdl-data-table__cell--non-numeric">{{ $download->quality }}</td>
					<td class="mdl-data-table__cell--non-numeric">{{ $download->size }}</td>
					<td>
						{!! Form::open([ 'url' => URL::action('EpisodeController@deleteLink', [ 'id' => $download->id ]), 'method' => 'delete', 'style' => 'width:100%' ]) !!}

						<button type="submit" class="mdl-button mdl-js-button mdl-button--icon" style="color:darkred">
							<i class="material-icons">delete</i>
						</button>

						{!! Form::close() !!}
					</td>
				</tr>
				@endforeach

				{!! Form::open([ 'url' => URL::action('EpisodeController@addLink', [ 'slug' => $data->anime, 'type' => $data->type, 'num' => $data->num ]), 'method' => 'put', 'style' => 'width:100%' ]) !!}

				<tr>
					<td class="mdl-data-table__cell--non-numeric" colspan="2"><i>Automático</i></td>
					<td class="mdl-data-table__cell--non-numeric">
						<div class="mdl-textfield mdl-js-textfield" style="margin-top:-20px; padding-bottom:0">
							<input class="mdl-textfield__input" type="text" name="link" value="{{ old('link') }}" />
							<label class="mdl-textfield__label" for="link">Link...</label>
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

		</div>
	</div>
@endsection