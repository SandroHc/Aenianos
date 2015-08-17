@extends('master')

@section('title')
	@yield('error') - Aenianos Fansub
@endsection

@section('head')
	<link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

	<style>
		.error {
			font-family: 'Lato', Calibri, sans-serif;
			font-size: 72px;
			font-weight: 100;
			color: #829097;
			width:100%;
			text-align: center;
			margin-top:40px;
			height: 50px;
		}
	</style>
@endsection

@section('content')
	<div class="error">@yield('error')</div>

	<a href="{{ URL::previous() }}" target="_self">Voltar</a>
@endsection