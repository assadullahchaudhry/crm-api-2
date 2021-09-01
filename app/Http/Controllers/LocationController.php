<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $countries = Country::all();

        $states = [];
        $cities = [];

        if ($countries->count()) {
            $states = State::where('country_id', $countries[0]->id)->get();

            if ($states->count()) {
                $cities = City::where('state_id', $states[0]->id)->get();
            } else {
                $cities = [];
            }
        }

        return response()->json([
            'status' => 'success',
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities
        ], 200);
    }

    public function getStatesCities(Request $request, $id)
    {
        $states = State::where('country_id', $id)->get();

        if ($states->count()) {
            $cities = City::where('state_id', $states[0]->id)->get();
        } else {
            $cities = [];
        }



        return response()->json([
            'status' => 'success',
            'states' => $states,
            'cities' => $cities
        ], 200);
    }
    public function getCities(Request $request, $id)
    {

        $cities = City::where('state_id', $id)->get();

        return response()->json([
            'status' => 'success',
            'cities' => $cities
        ], 200);
    }
}
