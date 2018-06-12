<div class="col-md-6">
    <div class="row text-center" style="margin-bottom: 30px;"><h2>Game Jams</h2></div>
    @if(count($gameSubmissions))

        <div id="load-search-game-submission">

        @foreach($gameSubmissions as $gs)
            <!-- repeat -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default  panel--styled">

                            <div class="panel-body">
                                <div class="col-md-12 panelTop">
                                    <div class="col-md-4">
                                        <a href="{{asset('games/'. $gs->idGameSubmission)}}"><img class="img-responsive" src="{{asset($gs->path)}}" alt="{{$gs->alt}}"/></a>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="{{asset('games/'. $gs->idGameSubmission)}}"><h3>{{$gs->title}}</h3></a>
                                        <p>{{$gs->description}}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /repeat -->
            @endforeach
        </div>


        <div class="clearfix"></div>
        <div class="row">
            <ul class="pagination pagination-game-jams-search" id="pagination-game-jams-upcoming">
                @for($i = 0; $i < ceil($gameSubmissionsCount / 6); $i++)
                    <li class="page-item @if($currentPageGameSubmissions == $i + 1) {{ 'active' }} @endif"><a
                                href="#" data-page="{{ $i + 1 }}" data-type="gameSubmissions"
                                class='page-link-game-jams-upcoming'>{{ $i + 1 }}</a></li>
                @endfor
            </ul>
        </div>

    @else
        <i>There is currently no game submissions for searched value</i>
    @endif
</div>
