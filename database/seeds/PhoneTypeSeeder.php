<?php

use Illuminate\Database\Seeder;

class PhoneTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = new \KW\Transactions\Models\PhoneType();
        $type->name = 'office';
        $type->name_translation = 'contact.office_phone';
        $type->save();

        $type = new \KW\Transactions\Models\PhoneType();
        $type->name = 'mobile';
        $type->name_translation = 'contact.mobile_phone';
        $type->save();

        $type = new \KW\Transactions\Models\PhoneType();
        $type->name = 'home';
        $type->name_translation = 'contact.home_phone';
        $type->save();
    }
}
