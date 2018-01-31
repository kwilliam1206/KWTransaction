<?php

use Illuminate\Database\Seeder;

class TranslatorLanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang = new \Waavi\Translation\Models\Language();
        $lang->locale = 'en';
        $lang->name = 'English';
        $lang->save();

        $lang = new \Waavi\Translation\Models\Language();
        $lang->locale = 'es';
        $lang->name = 'Spanish';
        $lang->save();

    }
}
