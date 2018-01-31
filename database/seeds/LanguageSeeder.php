<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang = new \KW\Transactions\Models\Language();
        $lang->name = 'English';
        $lang->code = 'en';
        $lang->save();
        $lang = new \KW\Transactions\Models\Language();
        $lang->name = 'Spanish';
        $lang->code = 'es';
        $lang->save();
        $lang = new \KW\Transactions\Models\Language();
        $lang->name = 'Turkish';
        $lang->code = 'tr';
        $lang->save();
    }
}
