@extends('layouts.frontEnd')

@section('pageTitle')
    {{$userData->username}}
@endsection

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad user-profile">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">{{$userData->username}}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center">
                        <img alt="User Avatar"
                             src="{{ asset($userData->avatarImagePath) }}"
                             style="padding-bottom: 15px;"
                             class="img-circle img-responsive">
                    </div>
                    <div class=" col-md-9 col-lg-9 ">
                        <table class="table table-user-information">
                            <tbody>
                            <tr>
                                <td>Username:</td>
                                <td>{{$userData->username}}</td>
                            </tr>
                            <tr>
                                <td>Joined:</td>
                                <td>{{ date('m/d/Y', $userData->createdAt) }}</td>
                            </tr>
                            <tr>
                                <td>User type:</td>
                                <td>
                                    @if(!empty($userRoles))
                                    <ul>
                                        @foreach($userRoles as $role)
                                            <li>{{$role->text}}</li>
                                        @endforeach
                                    </ul>
                                    @else
                                        No type
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><a href="mailto:{{$userData->avatarImagePath}}">{{$userData->email}}</a></td>
                            </tr>
                            <tr>
                                <td>Banned:</td>
                                <td>{{$userData->isBanned ? 'Yes': 'No'}}</td>
                            </tr>
                            </tbody>
                        </table>

                        @if($isEditButtonDisplayed)
                            <a href="{{asset('/profile/edit')}}" class="btn btn-primary">Edit my profile</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection