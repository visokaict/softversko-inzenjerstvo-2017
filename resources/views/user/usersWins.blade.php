@extends('layouts.frontEnd')

@section('pageTitle')
    Game Wins
@endsection

@section('content')
    <h2 class="games-title">Users Game Wins</h2>

    @include('ajax.loadGames')
@endsection