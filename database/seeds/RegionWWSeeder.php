<?php

use Illuminate\Database\Seeder;
use KW\Transactions\Models\Region;
use KW\Transactions\Models\Office;

class RegionWWSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = base_path().'/database/seeds/csv/kww_offices.csv';
        $header = null;
        $handle = fopen($filename, 'r');

        while ( ($row = fgetcsv($handle)) !== FALSE )
        {
            if (!$header) {
                $header = $row;

            } else {
                $values = array_combine($header, $row);
                $parentKWId = $values['parent_kw_id'];
                unset($values['parent_kw_id']);

                $currencyCode = $values['currency'];
                unset($values['currency']);

                if (!empty($currencyCode)) {
                    $currency = \KW\Transactions\Models\Currency::where('code', '=', $currencyCode)->first();
                    if ($currency) {
                        $values['default_currency'] = $currency->id;
                    }
                }

                if (empty($parentKWId)) {
                    Region::create($values);

                } elseif ($parentKWId == 101) {
                    $parent = Region::where('kw_id', '=', $parentKWId)->first();
                    $values['parent_id'] = $parent->id;
                    Region::create($values);

                } else {
                    $region = Region::where('kw_id', '=', $parentKWId)->first();
                    $values['region_id'] = $region->id;
                    $values['default_currency'] = empty($values['default_currency'])? $region->default_currency : $values['default_currency'];
                    Office::create($values);
                }
            }


        }
    }
}