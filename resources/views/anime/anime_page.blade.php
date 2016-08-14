@extends('master')

<?php $current_section = $data->title ?>

@section('head')
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dialog-polyfill/0.4.2/dialog-polyfill.min.css">
@endsection

@section('content-before')
	@include('anime.anime_header', [ 'data' => $data ])
@endsection

@section('content')
	@include('anime.anime', [ 'data' => $data ])
@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dialog-polyfill/0.4.2/dialog-polyfill.min.js" defer></script>

	<script>
		$(window).load(function() {
			$('.has-dl').click(function(e) {
				$('#' + this.id + '-dl').toggleClass('hidden');
			});

			var dialog = document.querySelector('#modal-official-cover');
			var closeButton = dialog.querySelector('button');
			var showButton = document.querySelector('#show-modal-cover');
			if(!dialog.showModal)
				dialogPolyfill.registerDialog(dialog);

			var showClickHandler = function(e) { dialog.showModal() };
			var closeClickHandler = function(e) { dialog.close() };

			showButton.addEventListener('click', showClickHandler);
			closeButton.addEventListener('click', closeClickHandler);
		});
	</script>
@endsection