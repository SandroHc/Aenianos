@extends('master')

@section('title', $anime->title)

@section('head')
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dialog-polyfill/0.4.2/dialog-polyfill.min.css">
@endsection

@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dialog-polyfill/0.4.2/dialog-polyfill.min.js" defer></script>
	<script src="{{ asset('show') }}" defer></script>
	<script src="{{ asset('js/build/defer-images.js') }}" defer></script>
@endpush

@section('content-before')
	@include('anime.page.header')
@endsection

@section('content')
	@include('anime.page.content')
@endsection