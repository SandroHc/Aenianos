@extends('master')

<?php $current_section = "Editar ". ($data->title ?? 'novo projeto') ?>

@section('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/redactor.css') }}">
@endsection

@section('content')
	{!! Form::open([ 'url' => URL::action('AdminController@updateAnime', [ 'slug' => $data->slug ?? 'novo' ]), 'files' => true, 'style' => 'width:100%' ]) !!}
	<h3><span class="navigation-parent"><a class="navigation-parent-link" href="{!! action('AdminController@showAnimeList') !!}" target="_self">Projetos</a> ></span> {{ isset($data) ? $data->title : 'Novo' }}</h3>

	@if(!$errors->isEmpty())
		@foreach($errors->all() as $error)
			<p>{{ $error }}</p>
		@endforeach
	@endif

	<div class="mdl-textfield mdl-js-textfield">
		Título
		<input class="mdl-textfield__input" type="text" name="title" value="{{ old('title', isset($data) ? $data->title : '')  }}" required="" />
		<label class="mdl-textfield__label" for="title"></label>
	</div>

	<br>

	{!! Form::textarea('synopsis', isset($data) ? $data->synopsis : '', [ 'id' => 'text' ]) !!}

	<br>

	<h4>Outras informações</h4>
	<h5>Estado</h5>

	<?php $values = [ 'Em lançamento', 'Em tradução', 'Concluído' ]; ?>
	@foreach($values as $cur)
		<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="status-{{ $cur }}">
			<input type="radio" id="status-{{ $cur }}" class="mdl-radio__button" name="status" value="{{ $cur }}" {{ (!isset($data) && $values[0] === $cur) || (isset($data) && $data->status === $cur) ? 'checked' : '' }} />
			<span class="mdl-radio__label">{{ $cur }}</span>
		</label>
		<br>
	@endforeach

	<div class="mdl-grid">
		<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--4-col">
			Episódios
			<input class="mdl-textfield__input" type="text" id="episodes" name="episodes" value="{{ $data->episodes ?? '' }}" />
			<label class="mdl-textfield__label" for="episodes"></label>
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--4-col">
			Lançamentos semanais
			<input class="mdl-textfield__input" type="text" id="airing_week_day" name="airing_week_day" value="{{ $data->airing_week_day ?? '' }}" />
			<label class="mdl-textfield__label" for="airing_week_day"></label>
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--4-col">
			Data de lançamento
			<input class="mdl-textfield__input" type="text" id="airing_date" name="airing_date" value="{{ isset($data->airing_date) ? $data->airing_date->toDateString() : '' }}" />
			<label class="mdl-textfield__label" for="airing_date"></label>
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--4-col">
			Géneros
			<input class="mdl-textfield__input" type="text" id="genres" name="genres" value="{{ $data->genres ?? '' }}" />
			<label class="mdl-textfield__label" for="genres"></label>
		</div>
	</div>

	<h5>Produção</h5>

	<div class="mdl-grid">
		<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--4-col">
			Produtor
			<input class="mdl-textfield__input" type="text" id="producer" name="producer" value="{{ $data->producer ?? '' }}" />
			<label class="mdl-textfield__label" for="producer"></label>
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--4-col">
			Diretor
			<input class="mdl-textfield__input" type="text" id="director" name="director" value="{{ $data->director ?? '' }}" />
			<label class="mdl-textfield__label" for="director"></label>
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--4-col">
			Website
			<input class="mdl-textfield__input" type="text" id="website" name="website" value="{{ $data->website ?? '' }}" />
			<label class="mdl-textfield__label" for="website"></label>
		</div>
	</div>

	<h5>Capa</h5>

	<p>
		<input type="file" id="cover" name="cover" />
		<input type="hidden" id="cover_offset" name="cover_offset" />
	</p>

	<div id="image-cropper">
		<div class="cropit-image-preview-container">
			<div class="cropit-image-preview"></div>
		</div>
	</div>

	<br>

	<h6>Capa oficial</h6>

	<p>
		<input type="file" name="official_cover" />
	</p>

	@if(isset($data) && !empty($data->official_cover))
		<img class="editor-capa" src="/{{ $data->official_cover }}">
	@endif

	<br><br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
		{{ isset($data) ? 'Atualizar' : 'Inserir' }}
	</button>

	<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ action('AdminController@showAnimeList') }}'" value="Cancelar">

	{!! Form::close() !!}

	<p>
		@if(isset($data))
			<h4>
				Episódios

				<button class="mdl-button mdl-js-button mdl-button--icon" onclick="window.location='{{ action('AdminController@showEpisodeEditor', [ 'id' => $data->id, 'type' => 'episodio', 'num' => 'novo' ]) }}'">
					<i class="material-icons">add</i>
				</button>
			</h4>
			<table class="mdl-data-table mdl-shadow--2dp">
				<thead>
				<tr>
					<td>#</td>
					<td class="mdl-data-table__cell--non-numeric">Links</td>
					<td class="mdl-data-table__cell--non-numeric"></td>
				</tr>
				</thead>
				<tbody>
				<?php $type = 'episodio'; ?>
					@foreach(\App\Models\Episode::where('anime', '=', $data->slug)->where('type', '=', $type)->groupBy([ 'num' ])->get([ 'num' ]) as $episode)
						<tr>
							<td>{{ $episode->num }}</td>
							<td class="mdl-data-table__cell--non-numeric">
								@foreach(\App\Models\Episode::where('anime', '=', $data->slug)->where('type', '=', 'episodio')->where('num', '=', $episode->num)->groupBy([ 'host_id' ])->get() as $host)
									<img src="{{ $host->host()->getResults()->icon ?? '/img/unknown_circle.png' }}" class="download-link-icon">
								@endforeach
							</td>
							<td>
								<a href="{{ URL::action('AdminController@showEpisodeEditor', [ 'slug' => $data->slug, 'type' => $type, 'num' => $episode->num ]) }}" style="color: black">
									<button class="mdl-button mdl-js-button mdl-button--icon">
										<i class="material-icons">edit</i>
									</button>
								</a>

								<a href="{{ URL::action('AdminController@deleteEpisodePrompt', [ 'slug' => $data->slug, 'type' => $type, 'num' => $episode->num ]) }}" style="color: black">
									<button type="submit"  class="mdl-button mdl-js-button mdl-button--icon">
										<i class="material-icons">delete</i>
									</button>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@else
			<p>Guarde o anime antes de adicionar episódios.</p>
		@endif
	</p>


	<script type="text/javascript" src="{{ asset('js/redactor.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/redactor.fontcolor.js') }}"></script>

	<script type="text/javascript" src="{{ asset('js/jquery.cropit.js') }}"></script>

	<script>
		$(function() {
			$('#text').redactor({
				imageUpload: '/editor/upload',
				plugins: ['fontcolor']
			});

			var $imageCropper = $('#image-cropper');
			$imageCropper.cropit({
				@if(isset($data) && !empty($data->cover))
				imageState: { src: '/{{ $data->cover }}' },
				onImageLoaded: function() { $imageCropper.cropit('offset', { x: 0, y: {{ $data->cover_offset or 0 }} }) },
				@endif
				width: 784,
				height: 200,
				$fileInput: $('#cover'),
				smallImage: 'stretch'
			});

			$('form').submit(function() {
				$('#cover_offset').val($imageCropper.cropit('offset').y);
			});
		});
	</script>
@endsection