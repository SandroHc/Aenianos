@extends('master')

<?php $current_section = "Editar ". ($num !== 'novo' ? '#'. $num : 'novo episódio') ?>
<?php $anime = \App\Models\Anime::get($slug); ?>

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp mdl-cell mdl-cell--8-col">

		<div class="mdl-card__supporting-text mdl-card--no-padding">

			{!! Form::open([ 'url' => URL::action('AdminController@updateEpisode', [ 'slug' => $slug, 'type' => $type, 'num' => $num ]), 'style' => 'width:100%' ]) !!}
			<h3><span class="navigation-parent"><a class="navigation-parent-link" href="{!! URL::action('AnimeController@showAnimePage', [ 'slug' => $slug ]) !!}" target="_self">{{ $anime->title }}</a> > </span> {{ $num !== 'novo' ? '#'. $num : 'Novo' }}</h3>

			@if(!$errors->isEmpty())
				@foreach($errors->all() as $error)
					<p>{{ $error }}</p>
				@endforeach
			@endif

			<div class="mdl-grid">
				<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--3-col">
					#
					<input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" name="num" value="{{ $data->num ?? ($num !== 'novo' ? $num : (($ep_num = \App\Models\Episode::where('anime', '=', $anime->slug)->where('type', '=', $type)->orderBy('num', 'DESC')->first()) !== NULL ? $ep_num->num + 1 : 1)) }}" />
					<label class="mdl-textfield__label" for="num"></label>
					<span class="mdl-textfield__error">Insira um número válido!</span>
				</div>
			</div>

			<h5>Tipo</h5>

			<?php $values = [ [ 'value' => 'episodio', 'visible' => 'Série'], [ 'value' => 'filme', 'visible' => 'Filme' ], [ 'value' => 'especial', 'visible' => 'Especial' ] ]; ?>
			@foreach($values as $cur)
				<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="type-{{ $cur['value'] }}">
					<input type="radio" id="type-{{ $cur['value'] }}" class="mdl-radio__button" name="type" value="{{ $cur['value'] }}" {{ (!isset($data) && $values[0]['value'] === $cur['value']) || ($type === $cur['value']) ? 'checked' : '' }} />
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

			<h4>Links</h4>
			@if(isset($data))
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
					@foreach($data as $link)
					<tr>
						<?php $host = \App\Models\Host::find($link->host_id); ?>
						<td style="padding-right:0"><img src="{{ $host->icon ?? '/img/unknown_circle.png' }}" class="download-link-icon"></td>
						<td class="mdl-data-table__cell--non-numeric">{{ $host->name ?? 'Desconhecido' }}</td>
						<td class="mdl-data-table__cell--non-numeric"><a href="{{ $link->link }}" target="_blank">{{ $link->link }}</a></td>
						<td class="mdl-data-table__cell--non-numeric">{{ $link->quality }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ $link->size }}</td>
						<td>
							{!! Form::open([ 'url' => URL::action('EpisodeController@deleteLink', [ 'id' => $link->id ]), 'method' => 'delete', 'style' => 'width:100%' ]) !!}

							<button type="submit"  class="mdl-button mdl-js-button mdl-button--icon">
								<i class="material-icons">delete</i>
							</button>

							{!! Form::close() !!}
						</td>
					</tr>
					@endforeach

					{!! Form::open([ 'url' => URL::action('EpisodeController@addLink', [ 'slug' => $slug, 'type' => $type, 'num' => $num ]), 'method' => 'put', 'style' => 'width:100%' ]) !!}

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
			@else
				<p>Guarde o episódio antes de adicionar links de download.</p>
			@endif

		</div>
	</div>
@endsection