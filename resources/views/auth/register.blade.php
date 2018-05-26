@extends('layouts.frontEnd')

@section('pageTitle', 'Registration')

@section('content')
    <div class="auth-box-body">
        <p class="auth-box-msg auth-title">Register a new membership</p>


        @isset($errors)
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
        @endisset

        <form action="{{asset('/register')}}" method="post">
            {{csrf_field()}}
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Username" name="tbUsername"
                       value="{{old('tbUsername')}}">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email" name="tbEmail"
                       value="{{old('tbEmail')}}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="tbPassword">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Retype password"
                       name="tbPassword_confirmation">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-8">
                    <label>
                        <a href="{{asset('/login')}}" style="font-weight:normal">I already have an account</a>
                    </label>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" name="btnSubmit">Register
                    </button>
                </div>
                <!-- /.col -->
            </div>
        </form>


    </div>
@endsection