@extends('layout')

@section('content')
<form method="POST" action="/auth/login">
	{!! csrf_field() !!}

	<div>
		Email
		<input type="email" name="email" value="{{ old('email') }}">
	</div>

	<div>
		Password
		<input type="password" name="password" id="password">
	</div>

	<div>
		<button type="submit">Login</button>
	</div>

</form>
@stop