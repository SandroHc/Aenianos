@extends('master')

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp">
		<div class="mdl-card__supporting-text mdl-card--no-padding">
			<h3>@yield('title', $current_section)</h3>

			@yield('text')
		</div>
	</div>
@endsection