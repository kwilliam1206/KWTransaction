<?php

use Illuminate\Database\Seeder;

class ListingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = new \KW\Transactions\Models\ListingStatus();
        $status->name = 'active';
        $status->name_translation = 'listing.active';
        $status->save();
        $status = new \KW\Transactions\Models\ListingStatus();
        $status->name = 'cancelled';
        $status->name_translation = 'listing.cancelled';
        $status->save();
        $status = new \KW\Transactions\Models\ListingStatus();
        $status->name = 'expired';
        $status->name_translation = 'listing.expired';
        $status->save();
        $status = new \KW\Transactions\Models\ListingStatus();
        $status->name = 'inactive';
        $status->name_translation = 'listing.inactive';
        $status->save();
        $status = new \KW\Transactions\Models\ListingStatus();
        $status->name = 'pending';
        $status->name_translation = 'listing.pending';
        $status->save();
        $status = new \KW\Transactions\Models\ListingStatus();
        $status->name = 'sold';
        $status->name_translation = 'listing.sold';
        $status->save();
    }
}
