@extends('master')

<?php $current_section = 'Editar '. ($data->title ?? 'novo projeto') ?>

@section('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/redactor.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/getmdl-select.min.css') }}">
@endsection

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp mdl-cell mdl-cell--8-col">

		<div class="mdl-card__supporting-text mdl-card--no-padding">

			{!! Form::open([ 'url' => URL::action('AnimeController@update', [ 'slug' => $data->slug ?? 'new' ]), 'files' => true, 'style' => 'width:100%' ]) !!}
			<h3><span class="navigation-parent"><a class="navigation-parent-link" href="{!! URL::action('AnimeController@list') !!}" target="_self">Projetos</a> ></span> {{ isset($data) ? $data->title : 'Novo' }}</h3>

			@if(!$errors->isEmpty())
				@foreach($errors->all() as $error)
					<p>{{ $error }}</p>
				@endforeach
			@endif

			<div class="mdl-textfield mdl-js-textfield">
				Título
				<input class="mdl-textfield__input" type="text" name="title" value="{{ old('title', isset($data) ? $data->title : '')  }}" required="" id="input" />
				<label class="mdl-textfield__label" for="title"></label>
			</div>

			<br>

			{!! Form::textarea('synopsis', isset($data) ? $data->synopsis : '', [ 'id' => 'text' ]) !!}

			<br>

			<h4>Outras informações</h4>

			<div class="mdl-grid">

				<div class="mdl-cell mdl-cell--2-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select">
						<input class="mdl-textfield__input" type="text" name="status" id="status" value="{{ $data->status ?? 'Em lançamento' }}" readonly tabIndex="-1">
						<label for="status">
							<i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
						</label>
						<label for="status" class="mdl-textfield__label">Estado</label>
						<ul for="status" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
							<li class="mdl-menu__item">Em lançamento</li>
							<li class="mdl-menu__item">Em tradução</li>
							<li class="mdl-menu__item">Concluído</li>
						</ul>
					</div>
				</div>

				<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--2-col">
					Episódios
					<label class="mdl-textfield__label" for="episodes"></label>
					<input class="mdl-textfield__input" type="text" id="episodes" name="episodes" value="{{ $data->episodes ?? '' }}" />
				</div>

				<div class="mdl-cell mdl-cell--2-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select">
						<input class="mdl-textfield__input" type="text" name="airing_week_day" id="airing_week_day" value="{{ $data->airing_week_day ?? 'N/A' }}" readonly tabIndex="-1" {{ $data != NULL && $data->status !== 'Em lançamento' ? 'disabled' : '' }}>
						<label for="airing_week_day">
							<i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
						</label>
						<label for="status" class="mdl-textfield__label">Lançamentos semanais</label>
						<ul for="airing_week_day" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
							<li class="mdl-menu__item" data-val="?">N/A</li>
							<li class="mdl-menu__item">segunda</li>
							<li class="mdl-menu__item">terça</li>
							<li class="mdl-menu__item">quarta</li>
							<li class="mdl-menu__item">quinta</li>
							<li class="mdl-menu__item">sexta</li>
							<li class="mdl-menu__item">sábado</li>
							<li class="mdl-menu__item">domingo</li>
						</ul>
					</div>
				</div>

				<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--2-col">
					Época de lançamento
					<input class="mdl-textfield__input" type="text" id="premiered" name="premiered" value="{{ isset($data->premiered) ? $data->premiered : '' }}" />
					<label class="mdl-textfield__label" for="premiered"></label>
				</div>

				<div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--2-col">
					Géneros
					<label class="mdl-textfield__label" for="genres"></label>
					<input class="mdl-textfield__input" type="text" id="genres" name="genres" value="{{ $data->genres ?? '' }}" />
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
				<img class="editor-capa" src="{{ $data->official_cover }}">
			@endif

			<br><br>

			<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
				{{ isset($data) ? 'Atualizar' : 'Inserir' }}
			</button>

			<input type="button" class="mdl-button mdl-js-button" onclick="window.location='{{ isset($data) ? URL::action('AnimeController@page', [ 'slug' => $data->slug ]) : URL::action('AnimeController@list') }}'" value="Cancelar">

			{!! Form::close() !!}

			<hr>
			<h3>Downloads</h3>

			@if(isset($data))
				<?php
					$types = [
						[ 'name' => 'Episódio', 'title' => 'Episódios' ],
						[ 'name' => 'Especial', 'title' => 'OVAs' ],
						[ 'name' => 'Filme', 'title' => 'Filmes' ],
					];
				?>

				@foreach($types as $type)
					<div class="mdl-cell mdl-cell--6-col">
						<h4>{{ $type['title'] }}</h4>
						<table class="mdl-data-table mdl-shadow--2dp" style="width: 100%">
							<thead>
							<tr>
								<td>#</td>
								<td class="mdl-data-table__cell--non-numeric">Título</td>
								<td class="mdl-data-table__cell--non-numeric">Links</td>
								<td class="mdl-data-table__cell--non-numeric"></td>
							</tr>
							</thead>
							<tbody>
								<tr>
								{!! Form::open([ 'url' => URL::action('EpisodeController@add', [ 'slug' => $data->slug, 'type' => $type['name'] ]), 'method' => 'put' ]) !!}
									<td style="padding: 0">
										<div class="mdl-textfield mdl-js-textfield" style="width: 2em; padding: 0">
											<input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" name="num" placeholder="#" value="{{ ($ep = \App\Models\Episode::where([ ['anime', '=', $data->slug], ['type', '=', $type['name']] ])->orderBy('num', 'DESC')->first()) !== NULL ? $ep->num + 1 : 1 }}" />
											{{--<label class="mdl-textfield__label" for="num"></label>--}}
											<span class="mdl-textfield__error">Insira um número válido!</span>
										</div>
									</td>
									<td class="mdl-data-table__cell--non-numeric" colspan="2">
										<div class="mdl-textfield mdl-js-textfield" style="width: 100%; padding: 0">
											<input class="mdl-textfield__input" type="text" name="title" placeholder="Título (opcional)"/>
											{{--<label class="mdl-textfield__label" for="title"></label>--}}
										</div>
									</td>
									<td>
										<button type="submit" class="mdl-button mdl-js-button mdl-button--icon" style="color:black">
											<i class="material-icons">save</i>
										</button>
									</td>

									<input type="hidden" name="type" value="{{ $type['name'] }}" />
								{!! Form::close() !!}
								</tr>

								@foreach($data->episodes()->where('type', '=', $type['name'])->groupBy([ 'num' ])->get() as $episode)
									<tr>
										<td>{{ $episode->num }}</td>
										<td class="mdl-data-table__cell--non-numeric">{{ $episode->title }}</td>
										<td class="mdl-data-table__cell--non-numeric">
											@foreach($episode->downloads()->orderBy('host_id', 'ASC')->get() as $download)
												<a href="{{ $download->link }}" title="{{ $download->host->name ?? '' }}">
													<img src="{{ $download->host->icon ?? '/img/unknown_circle.png' }}" class="download-link-icon">
												</a>
											@endforeach
										</td>
										<td>
											<a href="{{ URL::action('EpisodeController@manage', [ 'slug' => $data->slug, 'type' => $type['name'], 'num' => $episode->num ]) }}" style="color:black">
												<button class="mdl-button mdl-js-button mdl-button--icon">
													<i class="material-icons">edit</i>
												</button>
											</a>

											<a href="{{ URL::action('EpisodeController@deleteWarning', [ 'slug' => $data->slug, 'type' => $type['name'], 'num' => $episode->num ]) }}" style="color:darkred">
												<button class="mdl-button mdl-js-button mdl-button--icon">
													<i class="material-icons">delete</i>
												</button>
											</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endforeach

			@else
				<p>Guarde o anime antes de adicionar episódios.</p>
			@endif

		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/redactor.min.js') }}" defer></script>
	<script type="text/javascript" src="{{ asset('js/redactor.fontcolor.js') }}" defer></script>
	<script type="text/javascript" src="{{ asset('js/jquery.cropit.js') }}" defer></script>

	<script type="text/javascript" src="{{ asset('js/build/anime-editor.js') }}" defer></script>

	<script type="text/javascript" src="{{ asset('js/getmdl-select.min.js') }}" defer async></script>

	<script defer>
		$(window).load(function() {
			$('#text').redactor({
				imageUpload: '/editor/upload',
				plugins: ['fontcolor']
			});

			var $imageCropper = $('#image-cropper');
			$imageCropper.cropit({
				@if(isset($data) && !empty($data->cover))
				imageState: { src: '{{ $data->cover }}' },
				onImageLoaded: function() { $imageCropper.cropit('offset', { x: 0, y: {{ $data->cover_offset / 100 }} * $imageCropper.cropit('imageSize').height })	},
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