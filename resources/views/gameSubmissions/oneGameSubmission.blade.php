@extends('layouts.frontEnd')

@section('pageTitle')
    Game Name
@endsection

@section('cssfiles')
    <link href="{{asset('css/game.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<!-- TODO -->
<div class="game-cover-image">
    <p class="text-center">SLIDER</p>
</div>
<div class="game-header">
   <div class="game-header-inner">
       <div class="game-header-left float-left">
           Image, username, date
       </div>
       <div class="game-header-right float-right">
           Views, downloads
       </div>
        <div class="clearfix"></div>
   </div>
</div>
<div class="game-content">
    <div class="game-content-left col-lg-8 float-left">
        Title
    </div>
    <div class="game-content-right col-lg-4 float-right">
        Badges
    </div>
    <div class="clearfix"></div>
    <div class="game-comments">
        Comments
    </div>
</div>
<!-- -->
@endsection