<div class="mdl-cell mdl-cell--8-col" style="margin: 15px auto">
	{!! $paginator->render(new \App\Paginator\CustomPaginator($paginator)) !!}
</div>