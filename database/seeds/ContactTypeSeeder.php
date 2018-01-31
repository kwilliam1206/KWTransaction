<?php

use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = new \KW\Transactions\Models\ContactType();
        $type->name = 'agent';
        $type->name_translation = 'contact.agent';
        $type->save();

        $type = new \KW\Transactions\Models\ContactType();
        $type->name = 'client';
        $type->name_translation = 'contact.client';
        $type->save();

        $type = new \KW\Transactions\Models\ContactType();
        $type->name = 'buyer';
        $type->name_translation = 'contact.buyer';
        $type->save();

        $type = new \KW\Transactions\Models\ContactType();
        $type->name = 'seller';
        $type->name_translation = 'contact.seller';
        $type->save();

        $type = new \KW\Transactions\Models\ContactType();
        $type->name = 'referral';
        $type->name_translation = 'contact.referral';
        $type->save();

        $type = new \KW\Transactions\Models\ContactType();
        $type->name = 'other';
        $type->name_translation = 'contact.other';
        $type->save();
    }
}
