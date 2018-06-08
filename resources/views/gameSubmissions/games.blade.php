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
        @if (count($games) > 0)
            @include('ajax.loadGames')
        @endif
    </div>
    <div class="loading-overlay"><img src="{{ asset('/images/loading.svg') }}" /></div>
</div>
<!-- /.container -->
@endsection

@section('jsfiles')
    <script type="text/javascript">
        $(document).ready(function(){
             $('body').on('click', '.pagination li a', function(e) {
                e.preventDefault();

                $('.games-container').css('opacity', '0.5');
                $('.loading-overlay').css('display', 'block');

                var url = $(this).attr('href');

                getGames(url);
                //window.history.pushState("", "", url);
            });

            $("#gamesSorter").on('change', function(){
                var value = $(this).val();

                $('.games-container').css('opacity', '0.5');
                $('.loading-overlay').css('display', 'block');

                var url = window.location.href;
                var newUrl;

                var regSort = /([?&]sort)=([^#&]*)/g;

                if(!/[?&]page=/.test(window.location.search)) {
                    newUrl = url + "?page=1";
                }

                if(/[?&]sort=/.test(window.location.search)) {
                    newUrl = url.replace(regSort, "$1=" + value);
                }
                else {
                    newUrl += "&sort=" + value;
                }

                getGames(newUrl);
                //window.history.pushState({state:'new'}, "", newUrl);
            });

            function getGames(url, sortBy) {
                $.ajax({
                    url : url
                }).done(function (data) {
                    $('.loading-overlay').css('display', 'none');
                    $('.games-container').css('opacity', '1');
                    $('.games-container').html(data);
                }).fail(function () {
                    alert('Failed to load games.');
                });
            }
        });
    </script>
@endsection