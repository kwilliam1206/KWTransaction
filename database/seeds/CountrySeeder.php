<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = new \KW\Transactions\Models\Country();
        $country->name = 'United States';
        $country->code = 'US';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::with('parent')
            ->whereHas('parent', function($query) {
                $query->where('name', '=', 'KW North America');
            })
            ->where('name', '!=', 'Canada')
            ->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Canada';
        $country->code = 'CA';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','Canada')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Mexico';
        $country->code = 'MX';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','México')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Vietnam';
        $country->code = 'VN';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','Vietnam')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Southern Africa';
        $country->code = 'ZA';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','Southern Africa')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Indonesia';
        $country->code = 'ID';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','Indonesia')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Turkey';
        $country->code = 'TR';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','Türkiye')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Germany';
        $country->code = 'DE';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','Germany')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'United Kingdom';
        $country->code = 'GB';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','United Kingdom')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Portugal';
        $country->code = 'PT';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','Portugal')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'United Arab Emirates';
        $country->code = 'AE';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','Dubai')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Spain';
        $country->code = 'ES';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','España')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Costa Rica';
        $country->code = 'CR';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','Costa Rica')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Colombia';
        $country->code = 'CO';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','Colombia')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'China';
        $country->code = 'CN';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','大上海地区')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Germany';
        $country->code = 'BZ';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','Belize')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Panama';
        $country->code = 'PA';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','Panamá')->get());

        $country = new \KW\Transactions\Models\Country();
        $country->name = 'Poland';
        $country->code = 'PL';
        $country->save();
        $country->regions()->attach(\KW\Transactions\Models\Region::where('name','=','Polska')->get());

    }
}
