<p class="spotlight-cell-btn" onClick="toggleSpotlight()"><i class="material-icons">assignment</i></p>

<div id="spotlight">
	@include('anime.latest')
	@include('anime.calendar')
</div>

<script>
	var $spotlight;

	function toggleSpotlight() {
		if (!$spotlight) $spotlight = $("#spotlight");
		$spotlight.toggleClass("spotlight-change");
	}
</script>