@extends('layouts.frontEnd')

@section('pageTitle', 'Registration')

@section('content')
<div class="user-edit-content">
    <p class="text-center user-edit-title">Edit profile</p>

    @isset($errors)
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
    @endisset

    @if(session()->has('error'))
        <div class="alert alert-danger">
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <form action="{{ asset('/profile/edit') }}" method="post" enctype="multipart/form-data" data-toggle="validator" role="form">
        <div class="form-group user-edit-control">
            <input type="password" name="tbCurrentPassword" class="form-control" placeholder="Current password" data-minlength="6">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group user-edit-control">
            <input type="password" name="tbPassword" id="tbPassword" class="form-control" placeholder="New password" data-minlength="6">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group user-edit-control">
            <input type="password" name="tbPassword_confirmation" class="form-control" placeholder="Retype new password" data-minlength="6" data-match="#tbPassword">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <div class="help-block with-errors"></div>
        </div>
        <p>Upload avatar image:</p>
        <div class="form-group user-edit-file">
            <input type="file" accept="image/*" class="user-edit-upload-file-control" id="userUploadAvatar" name="fAvatarImage" data-filesize="2000" data-filetype="image/png,image/jpeg"/>
            <div class="drag-and-drop-overlay" id="drag-and-drop-overlay">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Click or Drag &amp; Drop Your File Here</p>
            </div>
            <div class="help-block with-errors"></div>

                <img id="uploadedImage" />
                <p class="image-filename" id="image-filename">Filename.jpg</p>

        </div>
        <div class="form-group user-edit-roles">
        @isset($userAvailableRoles)
            @foreach($userAvailableRoles as $role)
                <div class="checkbox">
                    <label>
                        <input type="checkbox" @if(in_array($role->idRole, $userHasRoles)) checked @endif name="userRoles[]" value='{{$role->idRole}}'> {{$role->text}}
                    </label>
                    <i class="reg-role-description">{{$role->description}}</i>
                </div>
            @endforeach
        @endisset
        </div>
        <div class="row">
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat btn-update-profile">Update</button>
            </div>
        </div>
         {{ csrf_field() }}
    </form>
</div>
@endsection

@section('jsfiles')
    <script>
        document.getElementById("userUploadAvatar").addEventListener("change", function(){
            var img = document.getElementById('uploadedImage');
            var imgFilename = document.getElementById("image-filename");
            if(this.files[0]){
                img.src = window.URL.createObjectURL(this.files[0]);
                img.style.opacity = 1;
                imgFilename.style.opacity = 1;
                imgFilename.innerHTML = this.files[0].name;
                document.getElementById("drag-and-drop-overlay").style.opacity = 0;
            }
        });
    </script>
@endsection