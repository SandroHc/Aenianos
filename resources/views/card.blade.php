@extends('master')

@section('content')
	<div class="mdl-card mdl-card--no-margin mdl-shadow--2dp">
		<div class="mdl-card__supporting-text mdl-card--no-padding">
			<h3>
				@hasSection('description')
					@yield('description')
				@else
					@yield('title')
				@endif
			</h3>

			@yield('body')
		</div>
	</div>
@endsection