<?php

use Illuminate\Database\Seeder;
use KW\Transactions\Models\Role;
use KW\Transactions\Models\Office;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Mexico
        $mexico = Office::where('kw_id', '=', 6250)->first()->id;
        //Turkey
        $turkey = Office::where('kw_id', '=', 6053)->first()->id;

        $user = new \KW\Transactions\Models\User();
        $user->username = 'KwAdmin';
        $user->email = 'admin@kw.com';
        $user->password = Hash::make('password1');
        $user->first_name = 'Admin';
        $user->last_name = 'Admin';
        $user->status_change_date = new \DateTime();
        $user->save();

        $role = Role::where('name','=','super_admin')->first();
        $user->roles()->attach($role,['office_id'=>$turkey]);
        $user->roles()->attach($role,['office_id'=>$mexico]);

        $user = new \KW\Transactions\Models\User();
        $user->username = 'KwriExecutive';
        $user->email = 'kwri_exec@kw.com';
        $user->password = Hash::make('password1');
        $user->first_name = 'KWRI';
        $user->last_name = 'Executive';
        $user->status_change_date = new \DateTime();
        $user->save();

        $role = Role::where('name','=','kwri_executive')->first();
        $user->roles()->attach($role,['office_id'=>$turkey]);

        $user = new \KW\Transactions\Models\User();
        $user->username = 'RegionAdmin';
        $user->email = 'region_admin@kw.com';
        $user->password = Hash::make('password1');
        $user->first_name = 'Region';
        $user->last_name = 'Admin';
        $user->status_change_date = new \DateTime();
        $user->save();

        $role = Role::where('name','=','region_admin')->first();
        $user->roles()->attach($role,['office_id'=>$turkey]);

        $user = new \KW\Transactions\Models\User();
        $user->username = 'McMCA';
        $user->email = 'mc_mca@kw.com';
        $user->password = Hash::make('password1');
        $user->first_name = 'MC';
        $user->last_name = 'MCA';
        $user->status_change_date = new \DateTime();
        $user->save();

        $role = Role::where('name','=','mc_mca')->first();
        $user->roles()->attach($role,['office_id'=>$turkey]);

        $user = new \KW\Transactions\Models\User();
        $user->username = 'LeadAgent';
        $user->email = 'lead_agent@kw.com';
        $user->password = Hash::make('password1');
        $user->first_name = 'Lead';
        $user->last_name = 'Agent';
        $user->status_change_date = new \DateTime();
        $user->save();

        $role = Role::where('name','=','lead_agent')->first();
        $user->roles()->attach($role,['office_id'=>$turkey]);

        $user = new \KW\Transactions\Models\User();
        $user->username = 'JohnAgent';
        $user->email = 'agent@kw.com';
        $user->password = Hash::make('password1');
        $user->first_name = 'John';
        $user->last_name = 'Agent';
        $user->status_change_date = new \DateTime();
        $user->save();

        $role = Role::where('name','=','agent')->first();
        $user->roles()->attach($role,['office_id'=>$turkey]);


    }
}
