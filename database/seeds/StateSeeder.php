<?php

use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $state = new \KW\Transactions\Models\State();
        $state->name = 'Istanbul';
        $state->code = '34';
        $state->country()->associate(\KW\Transactions\Models\Country::where('code','=','TR')->first());
        $state->save();

        $state = new \KW\Transactions\Models\State();
        $state->name = 'Ankara';
        $state->code = '06';
        $state->country()->associate(\KW\Transactions\Models\Country::where('code','=','TR')->first());
        $state->save();
    }
}
