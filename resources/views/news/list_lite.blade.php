@foreach($paginator = \App\Models\News::orderBy('created_at', 'DESC')->paginate(10) as $data)
	@include('news.tile')
@endforeach

@include('pagination')