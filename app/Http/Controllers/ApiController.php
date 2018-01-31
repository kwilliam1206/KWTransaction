<?php

namespace KW\Transactions\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use KW\Transactions\Http\Requests;
use KW\Transactions\Models\City;
use KW\Transactions\Models\Office;
use Auth;
use KW\Transactions\Models\User;

class ApiController extends Controller
{
    public function getCities(){
        if($state_id = Input::get('state_id'))
            return response()->json(City::where('state_id','=',$state_id)->get());
    }

    public function getMentions(Request $request)
    {
        $mentions = [
            ['username' => 'agent'],
            ['username' => 'office'],
            ['username' => 'region'],
        ];

        $office = Office::find($request->cookie('kw_office'));
        $users = User::inOffice($office->id)->get();

        foreach ($users as $user) {
            $mentions[] = ['name' => $user->name, 'username' => $user->username];
        }
        return $mentions;
    }
}
