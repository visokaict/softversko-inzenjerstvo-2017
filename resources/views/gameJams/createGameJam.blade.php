@extends('layouts.frontEnd')

@section('pageTitle')
    Create game jam
@endsection

@section('cssfiles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.css">
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css"
          rel="stylesheet">
    <style>
        #write_here {
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

            @isset($errors)
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            @endisset

            @if(session()->has('dateError'))
                <div class="alert alert-danger">
                    <div>{{ session('dateError') }}</div>
                </div>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger">
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if(session()->has('message'))
                <div class="alert alert-success">
                    <div>{{ session('message') }}</div>
                </div>
            @endif


            <form action="{{ asset('/game-jams/create') }}" method="POST" enctype="multipart/form-data"
                  data-toggle="validator" role="form">

                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="tbTitle" class="form-control" value="{{old('tbTitle')}}" required
                           pattern="^[a-zA-Z0-9\s]+$" data-minlength="3">
                    <div class="help-block with-errors"></div>
                </div>


                <div class="form-group">
                    <label>Start date: </label>
                    <div class='input-group date datetimepicker' id='datetimepicker1'>
                        <input type='text' class="form-control" name="dStartDate" id="dStartDate" value="{{old('dStartDate')}}"
                               data-datetime-gt="one-day" required/>
                        <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label>End date: </label>
                    <div class='input-group date datetimepicker' id='datetimepicker2'>
                        <input type='text' class="form-control" name="dEndDate" id="dEndDate" value="{{old('dEndDate')}}"
                               data-datetime-gt="#dStartDate" required/>
                        <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label>Voting end date: </label>
                    <div class='input-group date datetimepicker' id='datetimepicker3'>
                        <input type='text' class="form-control" name="dVotingEndDate" value="{{old('dVotingEndDate')}}"
                               data-datetime-gt="#dEndDate" required/>
                        <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">

                    <label>Criterias: </label>
                    @isset($criteria)
                        @foreach($criteria as $c )
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="chbCriteria[]"
                                           value='{{ $c->idGameCriteria }}' {{ (is_array(old('chbCriteria')) && in_array($c->idGameCriteria, old('chbCriteria'))) ? ' checked' : '' }}>{{ $c->name }}
                                </label>
                            </div>
                        @endforeach
                    @endisset

                </div>

                <div class="form-group">
                    <label for="coverImage">Cover image: </label>
                    <input id="coverImage" type="file" accept="image/*" name="fCoverImage" required data-filesize="2000" data-filetype="image/png,image/jpeg">
                    <div class="help-block with-errors"></div>
                    <p class="help-block">This will be your cover image.</p>
                </div>

                <div class="form-group">
                    <label>Others can vote: </label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="chbOthers" {{old('chbOthers') ? 'checked' : ''}}>
                            Yes
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Lock submittion after submitting: </label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="chbLock" {{old('chbLock') ? 'checked' : ''}}>
                            Yes
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control resize-vertical" rows="5" id="description" name="taDescription"
                              required>{{old('taDescription')}}</textarea>
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label for="description">Content:</label>
                    <div class="row">
                        <div class="col-md-6">
                            <textarea id="smde" class="CodeMirror" name="taContent"></textarea>
                        </div>
                        <div class="col-md-6" id="write_here">
                        </div>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>

                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Create game jam</button>
                    </div>
                </div>
                {{ csrf_field() }}
            </form>


        </div>
    </div>
@endsection


@section('jsfiles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        var sample = [];
        var simplemde = new SimpleMDE({
            element: $("#smde")[0],
            toolbar: ["bold", "italic", "heading", "|", "quote", "unordered-list", "ordered-list", "|", "link", "image", "|", "guide"]
        });

        $(document).ready(function () {
            writeSample();
            simplemde.codemirror.on("change", function () {
                var renderedHTML = simplemde.options.previewRender(simplemde.value());
                $("#write_here").html(renderedHTML);
            });

            $('.datetimepicker').datetimepicker();
        });

        function writeSample() {
            var s = "";
            s = getSample();
            simplemde.value(s);
            var renderedHTML = simplemde.options.previewRender(simplemde.value());
            $("#write_here").html(renderedHTML);
        }

        function getSample() {
            var s = "{{old('taContent')}}";
            $.each(sample, function (index, value) {
                //alert( index + ": " + value );
                s = s + value + "\n\r";
            });
            return s;
        }
    </script>
@endsection