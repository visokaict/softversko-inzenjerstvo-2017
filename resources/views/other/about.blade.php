@extends('layouts.frontEnd')

@section('pageTitle', 'About us')

@section('content')
    <div>
        <h2 class="h-bold text-center about-title">About Slam Jams project</h2>

        <div class="row text-center">
            <p>
                This is school project about Game jams, people who has ideas and they would like to see what people can prototype around that idea.
            </p>
        </div>


        <h2 class="h-bold text-center about-title">About developers</h2>

        <div class="row">
            <div class="text-center">

                <div>
                    <div class="col-sm-12 col-md-6">

                        <div style="width: 100%; padding: 30px;" class="split-left">
                            <div class="split-image">
                                <img src="https://goranurukalo.github.io/images/Goran_Urukalo.png">
                            </div>
                            <h3>Goran Urukalo</h3>
                            <p>
                                Hi, i'm Full stack Developer, i'm enjoying making websites and applications.
                            </p>
                            <div>
                                <i class="fab fa-github"></i>
                                <a style="color: white;" target="_blank" href="https://github.com/goranurukalo">@goranurukalo</a>
                            </div>
                        </div>


                    </div>
                    <div class="col-sm-12 col-md-6">

                        <div style="width: 100%; padding: 30px;" class="split-right">
                            <div class="split-image">
                                <img src="{{ asset('images/lolwtf.jpg') }}">
                            </div>
                            <h3>Nikola Simonovic</h3>
                            <p>
                            It is easier to stay awake till 6 AM than to wake up at 6 AM.
                            </p>
                            <div>
                                <i class="fab fa-github"></i>
                                <a target="_blank" href="https://omfgdogs.com">@niksimon</a>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>

    </div>
@endsection