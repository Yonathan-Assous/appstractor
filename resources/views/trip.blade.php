@extends('layouts.app')

@section('content')

<!-- Include the above in your HEAD tag -->
<div id="fullscreen_bg" class="fullscreen_bg">
  <div class="container">
   <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel panel-primary">

          <h3 class="text-center">
          Trips of {{$name}}</h3>

          <div class="panel-body">    


           <table class="table table-striped table-condensed">
            <thead>
              <tr>

                <th>Departure Date</th>  
                <th>Destination Country</th>
                </tr>
              </thead>   
              <tbody>
                @foreach ($trips as $trip) 
                <tr>
                  <td>{{$trip->departure_date}}</td>
                  <td>{{$trip->name}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
   </div>
 </div>
</div>

    
  @endsection

  


