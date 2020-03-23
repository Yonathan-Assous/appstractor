<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\Trip;	
use Carbon\Carbon;
use App\User;



class TripController extends Controller {
	public function addTrip(Request $request) {
	     $countryId = $request->country_id;
		 $departure = Carbon::parse($request->departure_date)->format('Y-m-d');
		 $trip = new Trip();
		 $trip->addTrip($countryId, $departure);
    }

    public function deleteTrip(Request $request) {
    	$id = $request->id;
    	Trip::deleteTrip($id);
    	return response()->json([], 200);
    }

    public function getMyTrips() {
    	$trip = new Trip();
    	return $trip->getMyTrips();
    }

    public function getAllTrips() {
    	$trip = new Trip();
    	return $trip->getAllTrips();
    }

    public function getTripByUserId($id) {
    	$data['trips'] = $this->getTripByUserIdJSon($id);
    	$data['name'] = User::getNameById($id);
        return view('trip', $data);
    }

    public function getTripByUserIdJSon($id) {
    	$trip = new Trip();
    	return $trip->getTripByUserId($id);
    }
}