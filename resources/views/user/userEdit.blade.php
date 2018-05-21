@extends('layouts.frontEnd')

@section('pageTitle', 'Registration')

@section('content')
<div class="user-edit-content">
    <p class="text-center user-edit-title">Edit profile</p>
    <form action="../../index.html" method="post">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group">
        <input type="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group">
        <input type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group">
        <input type="password" class="form-control" placeholder="Retype password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="form-group user-edit-file">
        <p>Upload avatar image</p>
        <input type="file" class="form-control">
      </div>
      <div class="row">
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat btn-update-profile">Update</button>
        </div>
      </div>
    </form>
  </div>
@endsection