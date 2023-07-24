<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function store(Request $request){
        $country=new Country();
        $country->sortname=$request->sortname;
        $country->name=$request->name;
        $country->phonecode=$request->phonecode;
        $country->save();
    }


    public function storeStates(Request $request){
        $state=new State();
        $state->name=$request->name;
        $state->country_id=$request->country_id;
        $state->save();
    }
}
