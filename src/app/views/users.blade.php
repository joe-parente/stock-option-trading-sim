@extends('layout')

@section('content')
<h2>Users!</h2>
    @foreach($users as $user)
        <p>{{ $user->name }}</p>
    @endforeach
@stop
