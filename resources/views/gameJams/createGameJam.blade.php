@extends('layouts.frontEnd')

@section('pageTitle')
  Create game jam
@endsection

@section('cssfiles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.css">
  <style>
    #write_here{
      height: 380px;
      overflow-y: scroll;
    }
    .CodeMirror {
      height: 300px;
      border: 1px solid #bbb;
      border-radius: 5px;
      padding-top: 2px;
      padding-bottom: 2px;
      padding-left: 4px;
      padding-right: 4px;
    }
    
    .editor {
      height: 100%;
    }
  </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-offset-2 col-md-8">
    <p class="auth-box-msg auth-title">Create game jam</p>
    <form action="#" method="POST" enctype="multipart/form-data">

      <div class="form-group">
        <label>Criterias: </label>
        <div class="checkbox">
          <label>
            <input type="checkbox">
            Gameplay
          </label>
        </div>

        <div class="checkbox">
          <label>
            <input type="checkbox">
            Design
          </label>
        </div>
      </div>

      <div class="form-group">
          <label for="coverImage">Cover image: </label>
          <input id="coverImage" type="file" name="fCoverImage">

          <p class="help-block">This will be your cover image.</p>
      </div>
  
      <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control resize-vertical" rows="5" id="description" name="tbDescription"></textarea>
      </div> 

      <div class="form-group">
          <label for="description">Context:</label>
          <div class="row">
              <div class="col-md-6">
                <textarea id="smde" class="CodeMirror"></textarea>
              </div>
              <div class="col-md-6" id="write_here">
              </div>
          </div>
        </div> 

      {{-- <div class="form-group">
          <label for="gameFiles">Game file: </label>
          <input id="gameFiles" type="file" name="fGameFiles">

          <p class="help-block">Zip your game project.</p>
      </div> --}}

      <div class="row">
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Submit game</button>
        </div>
      </div>

    </form>


  </div>
</div>
@endsection


@section('jsfiles')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.js"></script>
  <script>
    var sample = []
    var simplemde = new SimpleMDE({element: $("#smde")[0], toolbar: ["bold", "italic", "heading", "|", "quote", "unordered-list", "ordered-list", "|", "link", "image", "|", "guide"]});

    $(document).ready(function() {
      writeSample();
      simplemde.codemirror.on("change", function(){
        var renderedHTML = simplemde.options.previewRender(simplemde.value());
        $("#write_here").html(renderedHTML);
      });
    });

    function writeSample() {
      var s = "";
      s = getSample();
      simplemde.value(s);
      var renderedHTML = simplemde.options.previewRender(simplemde.value());
      $("#write_here").html(renderedHTML);
    }

    function getSample() {
      var s = "";
        $.each(sample, function( index, value ) {
        //alert( index + ": " + value );
          s = s + value + "\n\r";
      });
      return s;
    }
  </script>
@endsection