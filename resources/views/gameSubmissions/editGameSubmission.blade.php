@extends('layouts.frontEnd')

@section('pageTitle')
  Edit Game Submission
@endsection

@section('content')
<div class="auth-box-body">
    <p class="auth-box-msg auth-title">Edit game submission</p>
    <form action="#" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="hIdGameJam" value="<GAME_JAM_ID>">

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
            <button type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
        </div>
      </div>

    </form>


  </div>
@endsection