@extends('master')

<?php $current_section = "Utilizadores" ?>

@section('content')
	<div style="position: absolute; right:16px; top: 24px">
		<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" onclick="window.location='{{ URL::action('Auth\AuthController@getRegister') }}'">
			<i class="material-icons">add</i>
		</button>
	</div>

	<h3>Utilizadores</h3>

	<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
		<thead>
		<tr>
			<th class="mdl-data-table__cell--non-numeric">Nome</th>
			<th class="mdl-data-table__cell--non-numeric">E-mail</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		@foreach($data as $user)
			<tr class="{{ $user->trashed() ? 'grid-cell-disabled' : '' }}">
				<td class="mdl-data-table__cell--non-numeric">{{ $user->name }}</td>
				<td class="mdl-data-table__cell--non-numeric">{!! Collective\Html\HtmlFacade::mailto($user->email) !!}</td>
				<td>
					{!! Form::open([ 'url' => 'admin/utilizadores/'. $user->id .'/desativar', 'style' => 'width:100%' ]) !!}

					<input type="hidden" name="id" value="{{ $user->id }}">

					<button type="submit" id="disable-{{ $user->id }}" class="mdl-button mdl-js-button mdl-button--icon" {{ Auth::id() == $user->id ? 'disabled' : '' }}>
						<i class="material-icons">{{ $user->trashed() ? 'checked' : 'delete' }}</i>
					</button>

					@if(Auth::id() !== $user->id)
						<div class="mdl-tooltip" for="disable-{{ $user->id }}">
							{{ $user->trashed() ? 'Ativar' : 'Desativar' }}
						</div>
					@else
						{{--{{ Auth::user() }}--}}
					@endif

					{!! Form::close() !!}
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>

	@include('pagination', [ 'paginator' => $data ])
@endsection
