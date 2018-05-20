@extends('layouts.frontEnd')

@section('pageTitle')
  Login
@endsection

@section('content')
<div class="auth-box-body">
    <p class="auth-box-msg auth-title">Login to start your session</p>
    <form action="#" method="post">

      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="tbUsernameEmail" placeholder="Username or Email">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
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
    </form>


  </div>
@endsection