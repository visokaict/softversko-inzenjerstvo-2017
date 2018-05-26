@extends('layouts.frontEnd')

@section('pageTitle')
  Contact us
@endsection

@section('content')

  <div class="jumbotron jumbotron-sm bg-white">
      <div class="container">
          <div class="row">
              <div class="col-sm-12 col-lg-12">
                  <h1 class="h1">
                      Contact us <small>Feel free to contact us</small></h1>
              </div>
          </div>
      </div>
  </div>
  <div class="container">
      <div class="row">
          <div class="col-md-8">
              <div class="well well-sm">
                  <form action="#" method="POST">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="name">
                                  Full Name</label>
                              <input type="text" class="form-control" id="name" name="tbFullName" placeholder="Enter name" required="required" />
                          </div>
                          <div class="form-group">
                              <label for="email">
                                  Email Address</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                  </span>
                                  <input type="email" class="form-control" id="email" name="tbEmail" placeholder="Enter email" required="required" /></div>
                          </div>
                          <div class="form-group">
                              <label for="subject">
                                  Subject</label>
                              <select id="subject" name="subject" class="form-control" name="soSubject" required="required">
                                  <option value="na" selected="">Choose One:</option>
                                  <option value="service">General Customer Service</option>
                                  <option value="suggestions">Suggestions</option>
                                  <option value="product">Product Support</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="name">
                                  Message</label>
                              <textarea name="message" id="message" class="form-control no-resize" rows="9" cols="25" name="tbMessage" required="required"
                                  placeholder="Message"></textarea>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">
                              Send Message</button>
                      </div>
                  </div>
                  </form>
              </div>
          </div>
          <div class="col-md-4">

              @isset($pollQuestion)
                  <form action="{{asset('/pollVote')}}" method="POST">
                      {{csrf_field()}}
                      <input type="hidden" name="idPollQuestion" value="{{$pollQuestion->idPollQuestion}}">

                      <h3>{{$pollQuestion->text}}</h3>

                      @foreach($pollAnswers as $a)
                          <div class="checkbox">
                              <label>
                                  <input type="radio" name="pollAnswer" value="{{$a->idPollAnswer}}"> {{$a->text}}
                              </label>
                          </div>
                      @endforeach
                      <button type="submit" class="btn btn-primary" id="btnSubmit" name="btnSubmit">Vote</button>
                  </form>

              @endif

          </div>
      </div>
  </div>

@endsection