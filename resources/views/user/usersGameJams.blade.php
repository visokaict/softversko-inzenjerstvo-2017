@extends('layouts.frontEnd')

@section('pageTitle')
    Game Jams
@endsection

@section('content')
    <h2 class="games-title">My Game Jams</h2>

    @include('ajax.loadGameJamsUpcoming')
@endsection