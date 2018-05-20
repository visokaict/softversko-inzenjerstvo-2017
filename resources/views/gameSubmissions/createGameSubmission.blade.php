@extends('layouts.frontEnd')

@section('pageTitle')
  Create Game Submission
@endsection

@section('content')
<div class="auth-box-body">
    <p class="auth-box-msg auth-title">Create game submission</p>
    <form action="#" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="hIdGameJam" value="<GAME_JAM_ID>">

    <!--
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group">
          <label for="exampleInputFile">File input</label>
          <input id="exampleInputFile" type="file">

          <p class="help-block">Example block-level help text here.</p>
      </div>
    -->

      <div class="form-group">
        <label>Categories: </label>
        <div class="checkbox">
          <label>
            <input type="checkbox">
            FPS
          </label>
        </div>

        <div class="checkbox">
          <label>
            <input type="checkbox">
            RPG
          </label>
        </div>
      </div>

      <div class="form-group">
          <label for="coverImage">Cover image: </label>
          <input id="coverImage" type="file" name="fCoverImage">

          <p class="help-block">This will be your cover and teaser image.</p>
      </div>

      <div class="form-group">
          <label for="screenShot">Screen shots: </label>
          <input id="screenShot" type="file" name="fScreenShots" multiple>

          <p class="help-block">Select up to 4 screen shots.</p>
      </div>
  
      <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control resize-vertical" rows="5" id="description" name="tbDescription"></textarea>
      </div> 

      <div class="form-group">
          <label for="gameFiles">Game file: </label>
          <input id="gameFiles" type="file" name="fGameFiles">

          <p class="help-block">Zip your game project.</p>
      </div>

      <div class="row">
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Submit game</button>
        </div>
      </div>

    </form>


  </div>
@endsection