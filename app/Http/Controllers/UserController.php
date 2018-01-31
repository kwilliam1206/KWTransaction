<?php

namespace KW\Transactions\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use KW\Transactions\Models\CustomFinancialAttribute;
use KW\Transactions\Models\Office;
use KW\Transactions\Models\Role;
use KW\Transactions\Models\User;
use KW\Transactions\Models\Currency;
use KW\Transactions\Models\Language;
use KW\Transactions\Models\Locale;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!Auth::user()->can('manage_user'), 403);

        $q = $request->get('q');

        if (empty($q)) {
            if (Auth::user()->hasRole('super_admin')) {
                $users = User::with(['roles'])
                    ->orderBy('last_name', 'asc')
                    ->orderBy('first_name', 'asc')
                    ->get();
            } else {
                $users = User::with(['roles'])
                    ->whereHas('roles', function ($query) use ($q) {
                        $query->whereIn('role_user.office_id', Auth::user()->getUserManagingOfficeIds());
                    })
                    ->orderBy('last_name', 'asc')
                    ->orderBy('first_name', 'asc')
                    ->get();
            }
        } else {
            if (Auth::user()->hasRole('super_admin')) {
                $users = User::with(['roles'])
                    ->where('first_name', 'like', '%' . $q . '%')
                    ->orWhere('last_name', 'like', '%' . $q . '%')
                    ->orWhere('email', 'like', '%' . $q . '%')
                    ->orderBy('last_name', 'asc')
                    ->orderBy('first_name', 'asc')
                    ->get();
            } else {
                $users = User::with(['roles'])
                    ->whereHas('roles', function ($query) use ($q) {
                        $query->whereIn('role_user.office_id', Auth::user()->getUserManagingOfficeIds());
                    })
                    ->where(function ($query) use ($q) {
                        $query->where('first_name', 'like', '%' . $q . '%')
                            ->orWhere('last_name', 'like', '%' . $q . '%')
                            ->orWhere('email', 'like', '%' . $q . '%');
                    })
                    ->orderBy('last_name', 'asc')
                    ->orderBy('first_name', 'asc')
                    ->get();
            }
        }

        return view('user.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!Auth::user()->can('manage_user'), 403);

        return view('user.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string|between:6,30',
            'language_id' => 'required|integer|exists:languages,id',
            'locale_id' => 'required|integer|exists:locales,id',
            'currency_id' => 'required|integer|exists:currencies,id'
        ]);

        $user = new User();
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');

        if (!empty($request->get('password'))) {
            $user->password = Hash::make($request->get('password'));
        }

        $user->sponsor_kw_uid = $request->get('sponsor_kw_uid');
        $user->sponsor_name = $request->get('sponsor_name');

        $language_id = $request->get('language_id');
        $language = Language::find($language_id);
        $user->language()->associate($language);

        $locale_id = $request->get('locale_id');
        $locale = Locale::find($locale_id);
        $user->locale()->associate($locale);

        $currency_id = $request->get('currency_id');
        $currency = Currency::find($currency_id);
        $user->currency()->associate($currency);

        $user->save();

        $roleId = $request->get('role_1');
        $officeId = $request->get('office_1');
        $role = Role::find($roleId);
        $user->roles()->attach($role,['office_id'=>$officeId]);

        return redirect()->route('user.edit', ['id' => $user->id])->with('status', trans('user.user_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request)
    {
        abort_if($user->id != Auth::id() && !Auth::user()->can('manage_user'), 403);

        $currentOffice = Office::with('region')->find($request->cookie('kw_office'));

        return view('user.edit', [
            'user' => $user,
            'currentOffice' => $currentOffice,
            'officeFinancialAttributes' => CustomFinancialAttribute::forOfficeUser($currentOffice, $user)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        abort_if($user->id != Auth::id() && !Auth::user()->can('manage_user'), 403);

        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|string|max:255|unique:users,email,'.$user->id,
            'password' => 'string|between:6,30',
            'language_id' => 'required|integer|exists:languages,id',
            'locale_id' => 'required|integer|exists:locales,id',
            'currency_id' => 'required|integer|exists:currencies,id'
        ]);

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');

        if (!empty($request->get('password'))) {
            $user->password = Hash::make($request->get('password'));
        }

        $user->sponsor_kw_uid = $request->get('sponsor_kw_uid');
        $user->sponsor_name = $request->get('sponsor_name');

        $language_id = $request->get('language_id');
        $language = Language::find($language_id);
        $user->language()->associate($language);

        $locale_id = $request->get('locale_id');
        $locale = Locale::find($locale_id);
        $user->locale()->associate($locale);

        $currency_id = $request->get('currency_id');
        $currency = Currency::find($currency_id);
        $user->currency()->associate($currency);

        $user->save();

        if ($user->id == Auth::id()) {
            return redirect()->route('user.edit', ['id' => $user->id])->with('status', trans('user.profile_updated'));
        }

        return redirect()->route('user.edit', ['id' => $user->id])->with('status', trans('user.user_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Update user roles.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function roles(Request $request, User $user)
    {
        abort_if(!Auth::user()->can('manage_user'), 403);

        $nRoles = $request->get('nRoles');

        $newRoles = [];
        for ($n=1; $n <= $nRoles; $n++) {
            $roleId = $request->get('role_'.$n);
            $officeId = $request->get('office_'.$n);
            if ($roleId && $officeId) {
                $newRoles[] = ['id'=>$roleId, 'office_id'=>$officeId];
            }
        }

        foreach ($user->roles as $uRole) {
            $saved = false;
            foreach ($newRoles as $i => $newRole) {
                //unchanged roles
                if ($newRole['id'] == $uRole->id && $newRole['office_id'] == $uRole->pivot->office->id) {
                    unset($newRoles[$i]);
                    $saved = true;
                }
            }

            if (!$saved) {
                echo 'delete '.$uRole->id.PHP_EOL;
                //delete no longer valid roles
                $user->roles()->detach($uRole,['office_id'=>$uRole->pivot->office->id]);
            }
        }

        //create new roles
        foreach ($newRoles as $newRole) {
            $role = Role::find($newRole['id']);
            $user->roles()->attach($role,['office_id'=>$newRole['office_id']]);
        }

        return redirect()->route('user.edit', ['id' => $user->id])->with('updateRolesStatus', trans('user.user_roles_updated'));
    }

}
