@extends('layouts.app')

@section('content')

<!-- Include the above in your HEAD tag -->
<div style="margin-bottom:50px" class="container">
  <h2 style="margin-bottom:20px"><i>My Simple Trip App</i></h2>
  <div class="row">
    <div class="col-md-5">
     <div class="form-group">
      <label for="sel1">Select Destination Country:</label>
      <select class="form-control" id="select_trip_country">
        @foreach ($countries as $country)
        <option class="add_trip_country" value={{$country->id}}>{{$country->name}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-md-5">
    <div class="form-group">
      <label for="sel1">Select Departure Date:</label>
      <br>
      <input class="form-control" id="add_trip_departure" type="date" min="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label style="visibility:hidden" for="sel1">Select Departure Date:</label>
      <br>
      <button id="add_trip" type="button" class="btn btn-primary form-control pure-material-button-contained">Add Trip</button>
    </div>
  </div>
</div>
</div>

<div id="fullscreen_bg" class="fullscreen_bg">
 <form class="form-signin">
  <div class="container">
   <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel panel-primary">

          <h3 class="text-center">
          My Trips</h3>

          <div class="panel-body">    


           <table id="table_my_trips" class="table table-striped table-condensed">
            <thead>
              <tr>

                <th onClick="sortMyTrips('departure_date')">
                  <div class="table-header-title">Departure Date</div>
                  <div id="departure_date_sort" class="sort-asc"></div>
                </th>  
                <th onClick="sortMyTrips('name')">
                <div class="table-header-title">Destination Country</div>
                <div id="name_sort" class="sort-asc"></div>
              </th>
                <th>
                </tr>
              </thead>   
              <tbody id="my_trips">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
   </div>

    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel panel-primary">

            <h3 class="text-center">
            All User's Upcoming Trips</h3>

            <div class="panel-body">    
              <table class="table table-striped table-condensed">
                <thead>
                  <tr>
                    <th>Departure Date</th>  
                    <th>Destination Country</th>
                    <th>First Name</th>

                  </tr>
                </thead>   
                <tbody id="all_first_trips">               
                </tbody>
              </table>
          </div>
        </div>
      </div>
    </form>
  </div>
  @endsection

  @section('scripts')
  <script>
    var myTrips = [];
    var currentSort = {
      "sortBy":"",
      "invertSort":true
    }

    function sortMyTrips(sortOrder){
      if(sortOrder == currentSort.sortBy){
        currentSort.invertSort = !currentSort.invertSort;
      }else{
        currentSort.sortBy = sortOrder;
        currentSort.invertSort = true;
      }
      myTrips = myTrips.sort(function(a,b){
        if(a[currentSort.sortBy] > b[currentSort.sortBy] ){
          return currentSort.invertSort ? -1 : 1;
        }else if (a[currentSort.sortBy] < b[currentSort.sortBy] ) {
          return currentSort.invertSort ? 1 : -1;
        } else {
          return 1;
        }
      });

      if (currentSort.invertSort) {
        $('#' + sortOrder + '_sort').removeClass().addClass('sort-desc');
      }
      else {
        $('#' + sortOrder + '_sort').removeClass().addClass('sort-asc');
      }
      showMyTrips(myTrips);
    }

function showMyTrips(response){
  document.getElementById("my_trips").innerHTML = "";
  jQuery.each(response, function(i,data) {
  $("#my_trips").append(
    "<tr id='my_trip_row_" + data.id + "'><td>" + data.departure_date + "</td><td>" + data.name + "</td><td><div id='my_trip_" + data.id + "' class='btn btn-sm btn-danger btn-block my_trip' onclick='deleteTrip(" + data.id + ")' >Cancel Trip</div></td></tr>"
    );
  })
}

function showAllTrips(){

}
    function getAllMyTrips() {
          $.ajax({
           type:'GET',
           url:'/get_my_trips',
           data: {
            
          },
          success:function(response) {
            $( "#my_trips" ).empty();
            myTrips = response;
            showMyTrips(response);
/*            jQuery.each(response, function(i,data) {
              $("#my_trips").append(
                "<tr id='my_trip_row_" + data.id + "'><td>" + data.departure_date + "</td><td>" + data.name + "</td><td><div id='my_trip_" + data.id + "' class='btn btn-sm btn-danger btn-block my_trip' onclick='deleteTrip(" + data.id+ ")' >Cancel Trip</div></td></tr>"
              );
 
            });
*/
      
          },
          error: function() {
            console.log('error');
          }
        });
      }

      function getAllTrips() {
          $.ajax({
           type:'GET',
           url:'/get_all_trips',
           data: {
            
          },
          success:function(response) {
            $("#all_first_trips").empty();
            jQuery.each(response, function(i,data) {
              $("#all_first_trips").append(
                "<tr><td>" + data.departure + "</td><td>" + data.country + "</td><td><a href=./trip_user/" + data.user_id + ">" + data.user_name + "</a></td></tr>"
              );
            });
          },
          error: function() {
            console.log('error');
          }
        });
      }

      function deleteTrip(id) {
        $.ajax({
         type:'POST',
         url:'/delete_trip',
         data: {
          'id': id,
          "_token": "{{csrf_token()}}"
          },
          success:function(data) {
            getAllMyTrips();
            getAllTrips();
          },
          error: function() {
            console.log('error');
          }
        });
      }

    $(document).ready(function() {
       getAllTrips();
       getAllMyTrips();

      //$('.dataTables_length').addClass('bs-select');

      $("#add_trip").click(function() {
        $.ajax({
           type:'POST',
           url:'/add_trip',
           data: {
            'country_id': $('#select_trip_country option:selected').val(),
            'departure_date': $('#add_trip_departure').val()  ,
            "_token": "{{csrf_token()}}"
          },
          success:function(data) {
              console.log('dsaadsdas');
              getAllMyTrips();
              getAllTrips();
          }
        });
      });      
    });
  </script>
  @endsection


