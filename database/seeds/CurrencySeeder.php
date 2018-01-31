<?php

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            ['USD', 'US Dollar', 'en_US'],
            ['MXN', 'Mexican Peso', 'es_MX'],
            ['AED', 'Emirati Dirham', 'ar_AE'],
            ['BZD', 'Belizean Dollar', 'en_BZ'],
            ['CNY', 'Chinese Yuan Renminbi', 'zh_Hans'],
            ['COP', 'Columbian Peso', 'en_US'],
            ['CRC', 'Costa Rican Colon', 'es_CR'],
            ['EUR', 'Euro', 'en_GB'],
            ['GBP', 'British Pound', 'en_GB'],
            ['IDR', 'Indonesian Rupiah', 'id_ID'],
            ['PLN', 'Polish Zloty', 'pl_PL'],
            ['TRY', 'Turkish Lira', 'tr_TR'],
            ['VND', 'Vietnamese Dong', 'vi_VN'],
            ['ZAR', 'South African Rand', 'zu_ZA'],
        ];

        foreach ($currencies as $d) {
            $currency = new \KW\Transactions\Models\Currency();
            $currency->code = $d[0];
            $currency->name = $d[1];
            $currency->locale = $d[2];
            $currency->save();
        }

    }
}
