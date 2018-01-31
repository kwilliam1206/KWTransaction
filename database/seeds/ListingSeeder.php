<?php

use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listing = new \KW\Transactions\Models\Listing();
        $property = new \KW\Transactions\Models\Property();
        $property->state()->associate(\KW\Transactions\Models\State::where('code','=','TX')->first());
        $property->city()->associate(\KW\Transactions\Models\City::where('name','=','Plano')->first());
        $property->address = '567 There';
        $property->year_built = '1999';
        $property->postal_code = '75094';
        $property->beds = '4';
        $property->baths = '3';
        $property->habitable_area_sq_m = '2000';
        $property->save();
        $listing->property()->associate($property);
        $listing->status()->associate(\KW\Transactions\Models\ListingStatus::where('name','=','active')->first());
        $listing->listing_id = 'KW1234';
        $listing->save();
    }
}
