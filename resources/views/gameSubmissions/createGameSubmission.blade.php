@extends('layouts.frontEnd')

@section('pageTitle')
    Create Game Submission
@endsection

@section('content')

    <div class="auth-box-body">
        <p class="auth-box-msg auth-title">Create game submission</p>

        <div>
            @isset($errors)
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            @endisset
        </div>

        <form action="{{asset('/games/create')}}" method="POST" enctype="multipart/form-data" data-toggle="validator"
              role="form">

            {{ csrf_field() }}
            <input type="hidden" name="hIdGameJam" value="{{$gameJamId}}">

            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="tbTitle" class="form-control" value="{{old('tbTitle')}}" required
                       pattern="^[a-zA-Z0-9\s]+$" data-minlength="3">
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                <label>Categories: </label>
                @if(!empty($gameCategories))
                    @foreach($gameCategories as $category)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cbCategories[]"
                                       value='{{ $category->idGameCategory }}' {{ (is_array(old('cbCategories')) && in_array($category->idGameCategory, old('cbCategories'))) ? ' checked' : '' }} >
                                {{$category->name}}
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="form-group">
                <label for="coverImage">Cover image: </label>
                <input id="coverImage" type="file" name="fCoverImage" required data-filesize="2000" data-filetype="image/png,image/jpeg">
                <div class="help-block with-errors"></div>
                <p class="help-block">This will be your cover and teaser image.</p>
            </div>

            <div class="form-group">
                <label for="screenShot">Screen shots: </label>
                <input id="screenShot" type="file" name="fScreenShots[]" multiple required data-filesize="2000" data-filetype="image/png,image/jpeg">
                <div class="help-block with-errors"></div>
                <p class="help-block">Select up to 8 screen shots.</p>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control resize-vertical" rows="5" id="description"
                          name="taDescription" required>{{old('taDescription')}}</textarea>
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                <label for="gamePlatform">Game platform: </label>
                <select class="form-control" name="soGamePlatform" id="gamePlatform" required>
                    <option {{empty( old('soGamePlatform') ) ? 'selected': ''}} disabled>Select game platform...
                    </option>
                    @foreach($gamePlatforms as $platform)
                        <option value="{{$platform->idPlatform}}" {{ old('soGamePlatform') == $platform->idPlatform ? 'selected': ''}} >{{$platform->name}}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                <label for="gameFiles">Game file: </label>
                <input id="gameFiles" type="file" name="fGameFiles" required data-filesize="2000" data-filetype="application/zip,application/octet-stream,application/x-zip-compressed,multipart/x-zip,application/x-rar-compressed">
                <div class="help-block with-errors"></div>
                <p class="help-block">Zip your game project.</p>
            </div>


            <br>
            <br>

            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Submit game</button>
                </div>
            </div>

        </form>


    </div>
@endsection