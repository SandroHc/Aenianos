<p class="spotlight__switch" onClick="toggleSpotlight()"><i class="material-icons">assignment</i></p>

<div id="spotlight">
	<div id="spotlight__content">
		@include('anime.latest')
		@include('anime.calendar')
	</div>
</div>

<script>
	var $spotlight;

	function toggleSpotlight() {
		if (!$spotlight) $spotlight = $("#spotlight__content");
		$spotlight.toggleClass("spotlight-change");
	}
</script>