@extends('layouts.frontEnd')

@section('pageTitle')
    Games
@endsection

@section('content')
    <h2 class="games-title">My Games</h2>

    @include('ajax.loadGames')
@endsection