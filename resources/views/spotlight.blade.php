<p class="spotlight__switch" onClick="toggleSpotlight()"><i class="material-icons">assignment</i></p>

<div id="spotlight__container">
	<div id="spotlight">
		@include('anime.latest')
		@include('anime.calendar')
	</div>
</div>

<script>
	var $spotlight;

	function toggleSpotlight() {
		if (!$spotlight) $spotlight = $("#spotlight");
		$spotlight.toggleClass("spotlight-change");
	}
</script>