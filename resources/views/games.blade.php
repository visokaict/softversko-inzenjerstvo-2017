@extends('layouts.frontEnd')

@section('content')
    <!-- Page Content -->
    <div class="container">
    <h2 class='margin-bottom-40'>
      Games <span class='text-muted'>(123 results)</span>
    </h2>
    <div>
      filters
       Top rated,  Recently added, most viewed
       choose category
    </div>
      <div class="row">
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/300x150" alt=""></a>
            <div class="card-body">  
              <h4 class="card-title">
                <a href="#">Game title</a>
              </h4>
              <h6 class="card-subtitle mb-2 text-muted">Submitted by: <span>Some Guy</span></h6
              <p class="card-subtitle mb-2 text-muted p-joind-submissions">Categories</p>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
    <div>
      paggination [1,2,3....10]
    </div>
    </div>
    <!-- /.container -->
@endsection