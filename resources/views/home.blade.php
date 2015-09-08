@extends('master')

@section('title', 'Aenianos Fansub')

@section('content-before')
	<p class="spotlight-cell-btn" onClick="toggleSpotlight()"><i class="material-icons">assignment</i></p>

	<div id="spotlight">
		@include('anime.latest')
		@include('calendar')
	</div>
@endsection

@section('content')
	@include('news.list_lite')
@endsection

<script>
	var $spotlight;

	function toggleSpotlight() {
		if(!$spotlight) $spotlight = $("#spotlight");

		$spotlight.toggleClass("spotlight-change");
	}
</script>