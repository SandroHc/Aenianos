@extends('master')

<?php $current_section = "Editar ". ($data->title ?? 'novo projeto') ?>

@section('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/redactor.css') }}">
@endsection

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp mdl-cell mdl-cell--8-col">

		<div class="mdl-card__supporting-text mdl-card--no-padding">

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
					Época de lançamento
					<input class="mdl-textfield__input" type="text" id="premiered" name="premiered" value="{{ isset($data->premiered) ? $data->premiered : '' }}" />
					<label class="mdl-textfield__label" for="premiered"></label>
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
					Nome original
					<input class="mdl-textfield__input" type="text" id="japanese" name="japanese" value="{{ $data->japanese ?? '' }}" />
					<label class="mdl-textfield__label" for="japanese"></label>
				</div>

				<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--4-col">
					Estúdio
					<input class="mdl-textfield__input" type="text" id="studio" name="studio" value="{{ $data->studio ?? '' }}" />
					<label class="mdl-textfield__label" for="studio"></label>
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

			<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ URL::action('AnimeController@showAnimePage', [ 'slug' => $data->slug ]) }}'" value="Cancelar">

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
						<?php $type = 'Episódio'; ?>
							@foreach($data->episodes()->where('type', '=', $type)->groupBy([ 'num' ])->get() as $episode)
								<tr>
									<td>{{ $episode->num }}</td>
									<td class="mdl-data-table__cell--non-numeric">
										@foreach($episode->downloads()->orderBy('host_id', 'ASC')->get() as $download)
											<a href="{{ $download->link }}" title="{{ $download->host->name ?? '' }}">
												<img src="{{ $download->host->icon ?? '/img/unknown_circle.png' }}" class="download-link-icon">
											</a>
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

		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/redactor.min.js') }}" defer></script>
	<script type="text/javascript" src="{{ asset('js/redactor.fontcolor.js') }}" defer></script>

	<script type="text/javascript" src="{{ asset('js/jquery.cropit.js') }}" defer></script>

	<script defer>
		$(window).load(function() {
			$('#text').redactor({
				imageUpload: '/editor/upload',
				plugins: ['fontcolor']
			});

			var $imageCropper = $('#image-cropper');
			$imageCropper.cropit({
				@if(isset($data) && !empty($data->cover))
				imageState: { src: '/{{ $data->cover }}' },
				onImageLoaded: function() { $imageCropper.cropit('offset', { x: 0, y: {{ $data->cover_offset or 0 }} / 100 * $imageCropper.cropit('imageSize').height }) },
				@endif
				width: 784,
				height: 200,
				$fileInput: $('#cover'),
				smallImage: 'stretch'
			});

			$('form').submit(function() {
				$('#cover_offset').val((-$imageCropper.cropit('offset').y / $imageCropper.cropit('imageSize').height) * 100);
			});
		});
	</script>
@endsection