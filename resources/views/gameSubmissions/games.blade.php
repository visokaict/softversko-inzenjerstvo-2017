@extends('layouts.frontEnd')

@section('pageTitle')
Games
@endsection

@section('cssfiles')
    <link href="{{asset('css/game.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<!-- Page Content -->
<div class="container">
    <h2 class='games-title'>Games <span class='text-muted'>({{ $gamesCount . ' ' . ($gamesCount == 1 ? "result" : "results") }})</span></h2>
    <div class="row">
        <div class="col-md-2 col-sm-3">
            <select class="form-control" id="gamesSorter">
                <option value="new">Newest</option>
                <option value="old">Oldest</option>
                <option value="top">Top rated</option>
                <option value="views">Most viewed</option>
                <option value="download">Most downloaded</option>
            </select>
        </div>
    </div>
    <div class="games-container">
        @if (count($games))
            @include('ajax.loadGames')
        @else
            <i>There is currently no games</i>
        @endif
    </div>
</div>
<!-- /.container -->
@endsection

@section('jsfiles')
    <script type="text/javascript">
        $(document).ready(function () {
            slamjam.games.initGamesPage();
        });
    </script>
@endsection