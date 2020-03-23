<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\Trip;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['countries'] = Country::Where('is_active', true)->get();
        $trips = new Trip();
        $data['myTrips'] = $trips->getMyTrips();
        return view('home', $data);
    }
}
