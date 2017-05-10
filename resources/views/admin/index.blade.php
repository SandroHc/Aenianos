@extends('master')

@section('title', 'Administração')

@section('content')
	<div class="mdl-card mdl-grid mdl-shadow--2dp">
		<div class="mdl-cell mdl-cell--6-col">
			{{ $numAnime = \App\Models\Anime::count() }} projetos<br>
			{{ $numEps = \App\Models\Episode::count() }} episódios ({{ $numEps / $numAnime }} por projeto)<br>
			{{ \App\Models\Episode::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count() }} episódios lançados no último mês
		</div>
		<div class="mdl-cell mdl-cell--2-col">
			<a href="{{ URL::action('AnimeController@admin') }}">Gerir Projetos</a>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div id="chart_projects"></div>
		</div>
	</div>

	<div class="mdl-card mdl-grid mdl-shadow--2dp">
		<div class="mdl-cell mdl-cell--8-col">
			{{ \App\Models\News::count() }} notícias<br>
			{{ \App\Models\News::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count() }} no último mês
		</div>
		<div class="mdl-cell mdl-cell--3-col">
			<a href="{{ action('NewsController@index') }}">Gerir Notícias</a>
			<br>
			<a href="">Gerir Categorias</a>
		</div>
		<div class="mdl-cell mdl-cell--1-col">
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ action('NewsController@create') }}'">
				<i class="material-icons">add</i>
			</button>
		</div>
	</div>

	<div class="mdl-card mdl-grid mdl-shadow--2dp">
		<div class="mdl-cell mdl-cell--8-col">
			{{ \App\User::count() }} utilizadores ativos<br>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<a href="{{ action('UserController@index') }}">Gerir Utilizadores</a>
			<br>
			<a href="{{ action('UserController@preferences') }}">Editar Perfil</a>
		</div>
	</div>
@endsection

@push('scripts')
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" defer>
		// Load the Visualization API and the corechart package.
		google.charts.load('current', { 'packages': [ 'corechart' ] });
		google.charts.setOnLoadCallback(drawChart);

		console.log("START");

		function drawChart() {
			console.log("LOAD");

			// Create the data table.
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Projetos');
			data.addColumn('number', 'Estado');
			data.addRows([
				@foreach([ 'Em lançamento', 'Em tradução', 'Concluído' ] as $status)
					[ '{!! $status !!}', {{ \App\Models\Anime::where('status', '=', $status)->count() }}],
				@endforeach
			]);

			// Set chart options
			var options = { };

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.PieChart(document.getElementById('chart_projects'));
			chart.draw(data, options);
		}
	</script>
@endpush