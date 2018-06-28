<div class="games-content">
    <div id="load" style="position: relative;">
        @if(count($games))

            @foreach($games as $game)
                <div class="col-md-4 col-sm-6 games-content-item">
                    <div class="card h-100">
                        <a href="{{asset('games/'. $game->idGameSubmission)}}"><img class="card-img-top game-item-img" src="{{asset($game->path)}}" alt="{{$game->alt}}"></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="{{asset('games/'. $game->idGameSubmission)}}">{{ $game->title }}</a>
                            </h4>
                            <h6 class="card-subtitle mb-2 text-muted">Submitted by: <span><a href="{{asset('/user/'.$game->username)}}">{{ $game->username }}</a></span></h6>
                            <p class="card-subtitle mb-2 p-joind-submissions">
                                @foreach($game->categories as $category)
                                    <span class="game-category">{{ $category->name }}</span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="clearfix"></div>
        @else
            <i>There is currently no games</i>
        @endif

    </div>
</div>
<div class="row">
    <ul class="pagination" id="pagination-games">
        @for($i = 0; $i < ceil($gamesCount / 9); $i++)
            <li class="page-item @if($currentPage == $i + 1) {{ 'active' }} @endif"><a href="{{ url()->current() . '?page=' . ($i + 1) . '&sort=' . $currentSort}}" class='page-link'>{{ $i + 1 }}</a></li>
        @endfor
    </ul>
</div>