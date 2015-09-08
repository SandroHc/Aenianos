@extends('master')

@section('title')
	Editar {{ isset($data) ? $data->title : 'novo projeto' }} - Aenianos Fansub
@endsection

@section('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/redactor.css') }}">
@endsection

@section('content')
	{!! Form::open([ 'url' => URL::action('AdminController@updateAnime', [ 'id' => isset($data) ? $data->id : 'novo' ]), 'files' => true, 'style' => 'width:100%' ]) !!}
	<h3><span class="navigation-parent"><a class="navigation-parent-link" href="{!! action('AdminController@showAnimeList') !!}" target="_self">Projetos</a> ></span> {{ isset($data) ? $data->title : 'Novo' }}</h3>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" name="title" value="{{ old('title', isset($data) ? $data->title : '')  }}" required="" />
		<label class="mdl-textfield__label" for="title">Título...</label>
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

	<br>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="airing_date" name="airing_date" value="{{ isset($data) ? $data->airing_date->toDateString() : '' }}" />
		<label class="mdl-textfield__label" for="airing_date">Data de lançamento...</label>
	</div>

	<br>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="airing_week_day" name="airing_week_day" value="{{ isset($data) ? $data->airing_week_day : '' }}" />
		<label class="mdl-textfield__label" for="airing_week_day">Lançamentos semanais...</label>
	</div>

	<br>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="episodes" name="episodes" value="{{ isset($data) ? $data->episodes : '' }}" />
		<label class="mdl-textfield__label" for="episodes">Episódios...</label>
	</div>

	<br>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="genres" name="genres" value="{{ isset($data) ? $data->genres : '' }}" />
		<label class="mdl-textfield__label" for="genres">Géneros...</label>
	</div>

	<br>

	<h5>Produção</h5>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="producer" name="producer" value="{{ isset($data) ? $data->producer : '' }}" />
		<label class="mdl-textfield__label" for="producer">Produtor...</label>
	</div>

	<br>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="director" name="director" value="{{ isset($data) ? $data->director : '' }}" />
		<label class="mdl-textfield__label" for="director">Diretor...</label>
	</div>

	<br>

	<div class="mdl-textfield mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="website" name="website" value="{{ isset($data) ? $data->website : '' }}" />
		<label class="mdl-textfield__label" for="website">Website...</label>
	</div>

	<br>

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
		<img class="editor-capa" src="{{ $data->official_cover }}">
	@endif

	<br><br>

	<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
		{{ isset($data) ? 'Atualizar' : 'Inserir' }}
	</button>

	<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ action('AdminController@showAnimeList') }}'" value="Cancelar">

	{!! Form::close() !!}

	<p>
		<h4>
			Episódios

			@if(isset($data))
				<button class="mdl-button mdl-js-button mdl-button--icon" onclick="window.location='{{ action('AdminController@showEpisodeEditor', [ 'id' => $data->id, 'type' => 'episodio', 'num' => 'novo' ]) }}'">
					<i class="material-icons">add</i>
				</button>
			@endif
		</h4>

		@if(isset($data))
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
				<tbody>
				@foreach(\App\Models\Episode::getEpisodeList($data->id) as $episode)
					<tr>
						<td class="mdl-data-table__cell--non-numeric">
							{{ $episode->typeToStr() }}
						</td>
						<td>
							@if($episode->num > 0)
								{{ $episode->num }}
							@else
								Torrent
							@endif
						</td>
						<td>
							<button class="mdl-button mdl-js-button mdl-button--icon" onclick="window.location='{!! action('AdminController@showEpisodeEditor', [ 'id' => $data->id, 'type' => $episode->type, 'num' => $episode->num ]) !!}'">
								<i class="material-icons">edit</i>
							</button>
							<button class="mdl-button mdl-js-button mdl-button--icon" onclick="window.location='{!! action('AdminController@deleteEpisodePrompt', [ 'id' => $data->id, 'type' => $episode->type, 'num' => $episode->num ]) !!}'">
								<i class="material-icons">delete</i>
							</button>
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
				imageState: { src: '{{ $data->cover }}' },
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