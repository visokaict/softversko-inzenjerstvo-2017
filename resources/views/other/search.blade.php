@extends('layouts.frontEnd')

@section('pageTitle', 'Search')

@section('content')
    <div>
        <div class="row text-center">
            <h1 class=" jumbotron-heading">Results for <i>"{{$searchedText}}"</i></h1>
        </div>
        <div class="row">


            @include('ajax.searchGameJams')

            @include('ajax.searchGameSubmissions')


        </div>
    </div>
@endsection

@section('jsfiles')
    <script>
        slamjam.search.initPage();
    </script>
@endsection