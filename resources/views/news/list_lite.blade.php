@foreach($paginator = \App\Models\News::orderBy('created_at', 'DESC')->paginate(10) as $news)
	@include('news.tile')
@endforeach

{{ $paginator->links('pagination') }}