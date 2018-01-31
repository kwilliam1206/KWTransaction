<?php

namespace KW\Transactions\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use KW\Transactions\Http\Requests;
use KW\Transactions\Models\City;
use KW\Transactions\Models\Listing;
use KW\Transactions\Models\ListingStatus;
use KW\Transactions\Models\Property;
use KW\Transactions\Models\State;
use Auth;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ListingStatus $status)
    {
        if($status){
            $listings = Listing::statusOf($status)->with(['property', 'status'])->get();
        }
        else{
            $listings = Listing::get();
        }
        return view('listing.index')
            ->with('status',$status)
            ->with('listings',$listings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $states = \KW\Transactions\Models\State::inRegion()->lists('name','id');

        return view($request->isXmlHttpRequest()? 'modal.create-listing' : 'listing.create')
            ->with('states',$states);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //todo: validation, auth and input sanitize
        $input = Input::all();
        if(!is_numeric(Input::get('state_id'))) {
            $state = new State();
            $state->name = Input::get('state_id');
            $state->country()->associate(Auth::user()->country);
            $state->save();
            $city = new City();
            $city->name = Input::get('city_id');
            $city->state()->associate($state);
            $city->save();
            $input['state_id'] = $state->id;
            $input['city_id'] = $city->id;
        }
        elseif(!is_numeric(Input::get('city_id'))){
            $city = new City();
            $city->name = Input::get('city_id');
            $city->state_id = Input::get('state_id');
            $city->save();
            $input['city_id'] = $city->id;
        }
        $property = Property::create($input);
        $listing = new Listing();
        $listing->listing_id = Input::get('listing_id');
        $listing->status_id = Input::get('status_id');
        $listing->property()->associate($property);
        $listing->save();

        if ($request->isXmlHttpRequest()) {
            return response()->json($listing);
        }

        return redirect()->route('listing.index')->with('message',trans('listing.created_msg'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Listing $listing)
    {
        $states = State::inRegion()->lists('name','id');
        $cities = City::where('state_id','=',$listing->property->state_id)->lists('name','id');
        return view('listing.edit')
            ->with('states',$states)
            ->with('listing',$listing)
            ->with('cities',$cities);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Listing $listing)
    {
        //todo: validation, auth and input sanitize
        $input = Input::all();
        if(!is_numeric(Input::get('state_id'))) {
            $state = new State();
            $state->name = Input::get('state_id');
            $state->country()->associate(Auth::user()->offices()->first()->country);
            $state->save();
            $city = new City();
            $city->name = Input::get('city_id');
            $city->state()->associate($state);
            $city->save();
            $input['state_id'] = $state->id;
            $input['city_id'] = $city->id;
        }
        elseif(!is_numeric(Input::get('city_id'))){
            $city = new City();
            $city->name = Input::get('city_id');
            $city->state_id = Input::get('state_id');
            $city->save();
            $input['city_id'] = $city->id;
        }
        $listing->property()->update($input);
        $listing->listing_id = Input::get('listing_id');
        $listing->status_id = Input::get('status_id');
        $listing->save();
        return redirect()->route('listing.index')->with('message',trans('listing.updated_msg'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listing $listing)
    {
        //todo: validation, auth and input sanitize
        $listing->delete();
        return redirect()->route('listing.index')->with('message',trans('listing.deleted_msg'));
    }
}
