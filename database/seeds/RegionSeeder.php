<?php

use Illuminate\Database\Seeder;
use KW\Transactions\Models\Region;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $naRegion = new Region();
        $naRegion->name = 'KW North America';
        $naRegion->kw_id = 100;
        $naRegion->save();


        $region = new Region();
        $region->name = 'KWRI';
        $region->kw_id = 0;
        $region->save();

        $region = new Region();
        $region->name = 'Texas-South';
        $region->kw_id = 1;
        $region->save();

        $region = new Region();
        $region->name = 'Texas - NNMM';
        $region->kw_id = 3;
        $region->save();

        $region = new Region();
        $region->name = 'Oklahoma';
        $region->kw_id = 4;
        $region->save();

        $region = new Region();
        $region->name = 'Mid-American';
        $region->kw_id = 5;
        $region->save();

        $region = new Region();
        $region->name = 'Southwest';
        $region->kw_id = 6;
        $region->save();

        $region = new Region();
        $region->name = 'Colorado';
        $region->kw_id = 7;
        $region->save();

        $region = new Region();
        $region->name = 'Florida-North';
        $region->kw_id = 8;
        $region->save();

        $region = new Region();
        $region->name = 'Florida-South';
        $region->kw_id = 9;
        $region->save();

        $region = new Region();
        $region->name = 'Carolinas';
        $region->kw_id = 10;
        $region->save();

        $region = new Region();
        $region->name = 'Maryland and D.C.';
        $region->kw_id = 11;
        $region->save();

        $region = new Region();
        $region->name = 'Virginia';
        $region->kw_id = 12;
        $region->save();

        $region = new Region();
        $region->name = 'Pennsylvania - Greater';
        $region->kw_id = 13;
        $region->save();

        $region = new Region();
        $region->name = 'Gulf States';
        $region->kw_id = 14;
        $region->save();

        $region = new Region();
        $region->name = 'Heartland - Greater';
        $region->kw_id = 15;
        $region->save();

        $region = new Region();
        $region->name = 'California-Southern';
        $region->kw_id = 16;
        $region->save();

        $region = new Region();
        $region->name = 'New England';
        $region->kw_id = 17;
        $region->save();

        $region = new Region();
        $region->name = 'Northwest';
        $region->kw_id = 18;
        $region->save();

        $region = new Region();
        $region->name = 'Southeast';
        $region->kw_id = 19;
        $region->save();

        $region = new Region();
        $region->name = 'California-Northern and Hawaii';
        $region->kw_id = 21;
        $region->save();

        $region = new Region();
        $region->name = 'MI/NO';
        $region->kw_id = 22;
        $region->save();

        $region = new Region();
        $region->name = 'Ohio Valley';
        $region->kw_id = 23;
        $region->save();

        $region = new Region();
        $region->name = 'California-LA Coastal';
        $region->kw_id = 24;
        $region->save();

        $region = new Region();
        $region->name = 'California-Central and Southern';
        $region->kw_id = 25;
        $region->save();

        $region = new Region();
        $region->name = 'New York-Tri State';
        $region->kw_id = 27;
        $region->save();

        $region = new Region();
        $region->name = 'North Central';
        $region->kw_id = 28;
        $region->save();

        $region = new Region();
        $region->name = 'California-Westside LA';
        $region->kw_id = 29;
        $region->save();

        $region = new Region();
        $region->name = 'Canada';
        $region->kw_id = 30;
        $region->save();

        $region = new Region();
        $region->name = 'California-Inland Empire';
        $region->kw_id = 32;
        $region->save();

        $region = new Region();
        $region->name = 'Utah';
        $region->kw_id = 33;
        $region->save();

        $region = new Region();
        $region->name = 'New York - Upstate';
        $region->kw_id = 34;
        $region->save();

        $region = new Region();
        $region->name = 'New York - Manhattan';
        $region->kw_id = 35;
        $region->save();

        $region = new Region();
        $region->name = 'Southern Arizona';
        $region->kw_id = 36;
        $region->save();

        Region::where('kw_id', '!=', 100)->update(['parent_id' => $naRegion->id]);
    }
}