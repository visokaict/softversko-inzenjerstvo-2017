@extends('layouts.frontEnd')

@section('pageTitle')
    Login
@endsection

@section('content')
    <div class="auth-box-body">
        <p class="auth-box-msg auth-title">Login to start your session</p>

        @isset($errors)
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
        @endisset

        <form action="{{ asset('/login') }}" method="post" data-toggle="validator" role="form">

            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="tbUsernameEmail" placeholder="Username or Email"
                       value="{{ old('tbUsernameEmail') }}" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="tbPassword" required data-minlength="6">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <div class="help-block with-errors"></div>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <label>
                        <a href="{{asset('/register')}}" style="font-weight:normal">Register a new membership</a>
                    </label>
                </div>

                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                </div>

            </div>


            {{ csrf_field() }}
        </form>
    </div>
@endsection