@extends('layouts.frontEnd')

@section('content')
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad user-profile" >
<div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Username</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="https://memegenerator.net/img/images/300x300/16075274/trolololo-2016.jpg" class="img-circle img-responsive"></div>
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Username:</td>
                        <td>Neki username</td>
                      </tr>
                      <tr>
                        <td>Joined:</td>
                        <td>06/23/2013</td>
                      </tr>
                      <tr>
                        <td>User type:</td>
                        <td>User</td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td><a href="mailto:info@support.com">email@jeee.com</a></td>
                    </tr>
                    <tr>
                        <td>Banned:</td>
                        <td>No</td>
                      </tr>
                    </tbody>
                  </table>
                  
                  <a href="#" class="btn btn-primary">Edit my profile</a>
                </div>
              </div>
            </div>
</div>

</div>
@endsection