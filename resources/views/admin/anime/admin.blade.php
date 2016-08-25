@extends('master')

@section('title')
	Projetos
@endsection

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp mdl-cell mdl-cell--8-col">

		<div class="mdl-card__supporting-text mdl-card--no-padding">

			<div style="position: absolute; right:16px; top: 24px">
				<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('AnimeController@add') }}'">
					<i class="material-icons">add</i>
				</button>
			</div>

			<h3>Projetos</h3>

			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col">
					<table class="mdl-data-table mdl-shadow--2dp" style="width: 100%">
						<thead>
						<tr>
							<td class="mdl-data-table__cell--non-numeric">Título</td>
							<td class="mdl-data-table__cell--non-numeric">Status</td>
							<td>Eps.</td>
							<td class="mdl-data-table__cell--non-numeric"></td>
						</tr>
						</thead>
						<tbody>
							@foreach($paginator = \App\Models\Anime::orderBy('created_at', 'DESC')->paginate(10) as $data)
								<tr>
									<td class="mdl-data-table__cell--non-numeric"><a href="{{ URL::action('AnimeController@page', ['slug' => $data->slug]) }}">{{ $data->title }}</a></td>
									<td class="mdl-data-table__cell--non-numeric">{{ $data->status }}</td>
									<td class="mdl-data-table__cell--non-numeric">{{ $data->episodes }}</td>
									<td>
										<a href="{{ URL::action('AnimeController@manage', [ 'slug' => $data->slug ]) }}" style="color:black">
											<button class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">edit</i></button>
										</a>

										<a href="{{ URL::action('AnimeController@deleteWarning', [ 'slug' => $data->slug ]) }}" style="color:darkred">
											<button class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">delete</i></button>
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					@include('pagination')
				</div>
			</div>
		</div>
	</div>
@endsection
