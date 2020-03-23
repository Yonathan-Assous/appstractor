<?php 
namespace App\Http\Controllers;

use App\Country;
use App\Trip;	
use Illuminate\Support\Facades\Auth;





class TestController extends Controller {
	public function index() {
		$user = Auth::User();
		$test = Trip::selectRaw('user_id as id, users.name as user_name, countries.name as country, min(departure_date) as departure')
		->where('departure_date', '>=', date('Y-m-d'))
    	->join('users', 'users.id', '=', 'user_id')
    	->join('countries', 'countries.id', '=', 'destination_country_id')
    	->groupBy('user_id', 'user_name', 'country')
    	->orderBy('departure')->get();

    	dd($test);
	}
}