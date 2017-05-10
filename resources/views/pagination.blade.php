@if ($paginator->hasPages())
	<div class="mdl-cell mdl-cell--8-col" style="margin: 15px auto">
		<ul class="pagination">
			<li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
				<a href="{{ $paginator->url(1) }}">
					<button class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">navigate_before</i></button>
				</a>
			</li>
			@for ($i = 1; $i <= $paginator->lastPage(); $i++)
				<li class="{{ ($paginator->currentPage() == $i) ? ' active blue darken-3' : '' }}">
					<a href="{{ $paginator->url($i) }}">{{ $i }}</a>
				</li>
			@endfor
			<li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
				<a href="{{ $paginator->url($paginator->currentPage()+1) }}">
					<button class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">navigate_next</i></button>
				</a>
			</li>
		</ul>
	</div>
@endif