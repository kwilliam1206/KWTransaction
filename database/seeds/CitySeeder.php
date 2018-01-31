<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $city = new \KW\Transactions\Models\City();
        $city->name = 'Istanbul';
        $city->state()->associate(\KW\Transactions\Models\State::where('code','=','34')->first());
        $city->save();

        $city = new \KW\Transactions\Models\City();
        $city->name = 'Ankara';
        $city->state()->associate(\KW\Transactions\Models\State::where('code','=','06')->first());
        $city->save();

    }
}
