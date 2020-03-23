<?php



namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\User;


class Trip extends Model
{
	private $user;

	public function __construct() {
		$this->user = Auth::User();
	}

    public function addTrip($countryId, $dateDeparture) {
    	$this->destination_country_id = $countryId;
    	$this->user_id = ($this->user)->id;
    	$this->departure_date = $dateDeparture;
    	$this->save();
    }

    public static function deleteTrip($id) {
    	$trip = static::where('id', $id)->first();
    	$trip->delete();
    }

    public function getMyTrips() {    	
    	return $this->getTripByUserId($this->user->id);
    }

    public function getAllTrips() {
    	return static::selectRaw('users.id as user_id, users.name as user_name, countries.name as country, min(departure_date) as departure')
		->where('departure_date', '>=', date('Y-m-d'))
    	->join('users', 'users.id', '=', 'user_id')
    	->join('countries', 'countries.id', '=', 'destination_country_id')
    	->groupBy('user_id', 'user_name', 'country')
    	->orderBy('departure')->get();
    	
    }
    
    public function getTripByUserId($id) {
    	return static::select('trips.id', 'countries.name', 'departure_date')
    	->where('user_id', $id)
		->where('departure_date', '>=', date('Y-m-d'))
    	->join('countries', 'countries.id', '=', 'destination_country_id')
    	->orderBy('departure_date')->get();
    }
}
