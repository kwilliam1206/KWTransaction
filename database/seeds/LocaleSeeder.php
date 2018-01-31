<?php

use Illuminate\Database\Seeder;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locale = new \KW\Transactions\Models\Locale();
        $locale->code = 'en_US';
        $locale->name = 'US';
        $locale->save();

        $locale = new \KW\Transactions\Models\Locale();
        $locale->code = 'es_MX';
        $locale->name = 'MX';
        $locale->save();

        $locale = new \KW\Transactions\Models\Locale();
        $locale->code = 'ar_AE';
        $locale->name = 'AE';
        $locale->save();

        $locale = new \KW\Transactions\Models\Locale();
        $locale->code = 'en_BZ';
        $locale->name = 'BZ';
        $locale->save();

        $locale = new \KW\Transactions\Models\Locale();
        $locale->code = 'zh_Hans';
        $locale->name = 'CN';
        $locale->save();

        $locale = new \KW\Transactions\Models\Locale();
        $locale->code = 'es_CR';
        $locale->name = 'CR';
        $locale->save();

        $locale = new \KW\Transactions\Models\Locale();
        $locale->code = 'en_GB';
        $locale->name = 'GB';
        $locale->save();

        $locale = new \KW\Transactions\Models\Locale();
        $locale->code = 'id_ID';
        $locale->name = 'ID';
        $locale->save();

        $locale = new \KW\Transactions\Models\Locale();
        $locale->code = 'pl_PL';
        $locale->name = 'PL';
        $locale->save();

        $locale = new \KW\Transactions\Models\Locale();
        $locale->code = 'tr_TR';
        $locale->name = 'TR';
        $locale->save();

        $locale = new \KW\Transactions\Models\Locale();
        $locale->code = 'vi_VN';
        $locale->name = 'VN';
        $locale->save();

        $locale = new \KW\Transactions\Models\Locale();
        $locale->code = 'zu_ZA';
        $locale->name = 'ZA';
        $locale->save();
    }
}
