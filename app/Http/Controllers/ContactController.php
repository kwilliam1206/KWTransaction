<?php

namespace KW\Transactions\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use KW\Transactions\Http\Requests;
use KW\Transactions\Http\Requests\CreateContactRequest;
use KW\Transactions\Models\City;
use KW\Transactions\Models\Contact;
use KW\Transactions\Models\ContactPhone;
use KW\Transactions\Models\ContactType;
use KW\Transactions\Models\PhoneType;
use KW\Transactions\Models\State;
use Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ContactType $type)
    {
        if($type){
            $contacts = Contact::with(['city','state'])->typeOf($type)->get();
        }
        else{
            $contacts = Contact::with(['city','state'])->get();
        }
        return view('contact.index-'.$type->rawname)
            ->with('contact_type',$type)
            ->with('contacts',$contacts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, ContactType $type)
    {
        $states = State::inRegion()->lists('name','id');

        return view($request->isXmlHttpRequest()? 'modal.create-'.$type->rawname : 'contact.create-'.$type->rawname)
            ->with('contact_type',$type)
            ->with('states',$states);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateContactRequest $request)
    {
        //todo: validation, auth and input sanitize
        $input = Input::all();
        $input['user_id'] = Auth::user()->id;
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
        $contact = Contact::create($input);
        if($number = Input::get('mobile_phone',false)) {
            $phone = new ContactPhone();
            $phone->number = $number;
            $phone->type()->associate(PhoneType::where('name','=','mobile')->first());
            if(Input::get('primary_phone') == $phone->type->id)
                $phone->primary = true;
            $contact->phones()->save($phone);
        }
        if($number = Input::get('home_phone',false)) {
            $phone = new ContactPhone();
            $phone->number = $number;
            $phone->type()->associate(PhoneType::where('name','=','home')->first());
            if(Input::get('primary_phone') == $phone->type->id)
                $phone->primary = true;
            $contact->phones()->save($phone);
        }
        if($number = Input::get('office_phone',false)) {
            $phone = new ContactPhone();
            $phone->number = $number;
            $phone->type()->associate(PhoneType::where('name','=','office')->first());
            if(Input::get('primary_phone') == $phone->type->id)
                $phone->primary = true;
            $contact->phones()->save($phone);
        }
        $contact_type = ContactType::where('id','=',$input['type_id'])->pluck('name')->first();

        if ($request->isXmlHttpRequest()) {
            return response()->json($contact);
        }

        switch($contact_type){
            case 'agent':
                $msg = trans('contact.agent_created_msg');
                break;
            default:
                $msg = trans('contact.client_created_msg');
                break;
        }
        return redirect()->route('contact.index.filter',['type'=>$contact_type])->with('message',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $states = State::inRegion()->lists('name','id');
        $cities = City::where('state_id','=',$contact->state_id)->lists('name','id');
        return view('contact.edit-'.$contact->type->rawname)
            ->with('states',$states)
            ->with('contact',$contact)
            ->with('cities',$cities);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //todo: validation, auth and input sanitize
        $input = Input::all();
        $input['user_id'] = Auth::user()->id;
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
        $contact->update($input);
        $contact->phones()->delete();
        if($number = Input::get('mobile_phone',false)) {
            $phone = new ContactPhone();
            $phone->number = $number;
            $phone->type()->associate(PhoneType::where('name','=','mobile')->first());
            if(Input::get('primary_phone') == $phone->type->id)
                $phone->primary = true;
            $contact->phones()->save($phone);
        }
        if($number = Input::get('home_phone',false)) {
            $phone = new ContactPhone();
            $phone->number = $number;
            $phone->type()->associate(PhoneType::where('name','=','home')->first());
            if(Input::get('primary_phone') == $phone->type->id)
                $phone->primary = true;
            $contact->phones()->save($phone);
        }
        if($number = Input::get('office_phone',false)) {
            $phone = new ContactPhone();
            $phone->number = $number;
            $phone->type()->associate(PhoneType::where('name','=','office')->first());
            if(Input::get('primary_phone') == $phone->type->id)
                $phone->primary = true;
            $contact->phones()->save($phone);
        }
        $contact_type = ContactType::where('id','=',$input['type_id'])->pluck('name')->first();
        switch($contact_type){
            case 'agent':
                $msg = trans('contact.agent_updated_msg');
                break;
            default:
                $msg = trans('contact.client_updated_msg');
                break;
        }
        return redirect()->route('contact.index.filter',['type'=>$contact_type])->with('message',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //todo: validation, auth and input sanitize
        $type=$contact->type->rawname;
        switch($type){
            case 'agent':
                $msg = trans('contact.agent_deleted_msg');
                break;
            default:
                $msg = trans('contact.client_deleted_msg');
                break;
        }
        $contact->delete();
        return redirect()->route('contact.index.filter',['type'=>$type])->with('message',$msg);
    }
}
