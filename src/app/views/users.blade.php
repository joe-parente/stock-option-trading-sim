@extends('layout')

@section('content')
<h2>Verfying database access</h2>
    @foreach($users as $user)
        <p>{{ $user->name }}</p>
    @endforeach
@stop
