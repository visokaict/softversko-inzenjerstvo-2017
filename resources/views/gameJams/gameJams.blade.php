@extends('layouts.frontEnd')

@section('pageTitle')
  Game Jams
@endsection

@section('cssfiles')
    <link rel="stylesheet" href="https://rawgit.com/almende/vis/master/dist/vis-timeline-graph2d.min.css">
@endsection

@section('content')
    <header>
       <section class="about-us py-5 " id="about-us">
      <div class="mt-5">
    <div class="row">
      <div class="container">
          <h2 class="text-center">Game Jams on Slam Jam</h2>
          <hr>
          <p class="col-md-8 col-md-offset-2 text-center">Slam Jam is a place for hosting and participating in game jams online. Anyone can start hosting a game jam immediately. Here you can find some of the game jams that are going on.</p>
      </div>
      <div class="col-md-4 col-md-offset-4">
          <button type="button" class="btn btn-success host-own-game-jam">Host own Game Jam</button>
      </div>
    </div>
  </div>
  </section>
    </header>


  <!-- chart section -->
  <div class="container-fluid no-padding">
    <div id="visualization"></div>
    
    <!-- prikazati jedan od ova dva , javascript-om -->
    
    <h3 class="text-center no-game-jam">
      There is currently no active Game Jam.
    </h3>
  </div>
  <!-- /chart section -->


    <!-- Page Content -->
    <div class="container">
      <h2 class="margin-bottom-40">Game Jams in progress</h2>
      <div class="row">
      
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/300x150" alt=""></a>
            <div class="card-body">
              
              <h4 class="card-title">
                <a href="#">Jam title</a>
              </h4>
              <h6 class="card-subtitle mb-2 text-muted">Hosted by: <span>Some Guy</span></h6>
              <p class="margin-bottom-5">Submitions closes in: <span>12h</span></p>
              <div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
  </div>
</div>
          <p class="card-subtitle mb-2 text-muted p-joind-submissions">10<span> joined</span> 3 <span>submissions</span></p>
          
            </div>
          </div>
        </div>
       
      </div>
      <!-- /.row -->



<h2 class="margin-bottom-40">Upcoming Game Jams</h2>
      <div class="row">
      
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/300x150" alt=""></a>
            <div class="card-body">
              
              <h4 class="card-title">
                <a href="#">Jam title</a>
              </h4>
              <h6 class="card-subtitle mb-2 text-muted">Hosted by: <span>Some Guy</span></h6>
    
              <p class="card-text margin-bottom-5">Starts in <span>5days</span></p>
              <p class="card-subtitle mb-2 text-muted p-joind-submissions">10<span> joined</span></p>
          
            </div>
          </div>
        </div>
       
      </div>
      <!-- /.row -->




    </div>
    <!-- /.container -->

  
<script src="https://rawgit.com/almende/vis/master/dist/vis.min.js"></script>
<script>
  // create a dataset with items
  // note that months are zero-based in the JavaScript Date object, so month 3 is April
  var items = new vis.DataSet([
    {id: 0, content: 'item 0', start: new Date(2018, 5, 1), end: new Date(2018, 5, 12), link: "as"},
    {id: 1, content: 'item 1', start: new Date(2018, 5, 6), end: new Date(2018, 5, 16), link: "as"},
    {id: 2, content: 'item 2', start: new Date(2018, 5, 18), end: new Date(2018, 5, 22), link: "as"},
    {id: 3, content: 'item 2', start: new Date(2018, 5, 16), end: new Date(2018, 5, 24), link: "as"},
  ]);

  // create visualization
  var container = document.getElementById('visualization');
  var options = {
		maxHeight: 400,
    editable: false,
    clickToUse: false,
    zoomable: false,
    selectable: false,
    start: new Date(2018, 5, 14),
    template: function(data,x ,y ){
				return `<a href='${data.link}'>${data.content}</a>`;
    }
  };

  var timeline = new vis.Timeline(container);
  timeline.setOptions(options);
  //timeline.setGroups(groups);
  timeline.setItems(items);


//
// DOCS: http://visjs.org/docs/timeline/
//
//dodati Start , End 
//dodaj boje neke

</script>


@endsection