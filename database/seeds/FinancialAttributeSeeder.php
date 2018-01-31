<?php

use Illuminate\Database\Seeder;

use KW\Transactions\Models\FinancialAttributeType;
use KW\Transactions\Models\FinancialAttribute;
use KW\Transactions\Models\CustomFinancialAttribute;
use KW\Transactions\Models\Region;

class FinancialAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $typePercent = new FinancialAttributeType();
        $typePercent->name = 'percent';
        $typePercent->name_translation = 'financial.attribute_type_percent';
        $typePercent->save();

        $typeDollar = new FinancialAttributeType();
        $typeDollar->name = 'dollar';
        $typeDollar->name_translation = 'financial.attribute_type_dollar';
        $typeDollar->save();

        $typeNumber = new FinancialAttributeType();
        $typeNumber->name = 'number';
        $typeNumber->name_translation = 'financial.attribute_type_number';
        $typeNumber->save();


        $attributes = [
            ['name' => 'associate_fee', 'type_id' => $typeDollar->id, 'value' => 25, 'lock_type' => true],
            ['name' => 'new_agent_fee', 'type_id' => $typeDollar->id, 'value' => 45, 'lock_type' => true],
            ['name' => 'renewal_fee', 'type_id' => $typeDollar->id, 'value' => 100, 'lock_type' => true],
            ['name' => 'agent_monthly_fee', 'type_id' => $typeDollar->id, 'value' => 5, 'lock_type' => true],
            ['name' => 'admin_monthly_fee', 'type_id' => $typeDollar->id, 'value' => 25, 'lock_type' => true],
            ['name' => 'eas_fee', 'type_id' => $typeDollar->id, 'value' => 100, 'lock_type' => true],
            //['name' => 'sla_fee', 'type_id' => $typeDollar->id, 'value' => 7500],
            ['name' => 'sla_fee', 'type_id' => $typePercent->id, 'value' => 35],
            ['name' => 'growth_share_fee', 'type_id' => $typePercent->id, 'value' => 2],
            ['name' => 'growth_share_fee_to_kwri', 'type_id' => $typePercent->id, 'value' => 50, 'lock_type' => true],
            ['name' => 'royalty_fee', 'type_id' => $typePercent->id, 'value' => 6],
            ['name' => 'royalty_fee_to_region', 'type_id' => $typePercent->id, 'value' => 50, 'lock_type' => true],
            ['name' => 'royalty_fee_to_worldwide', 'type_id' => $typePercent->id, 'value' => 50, 'lock_type' => true],

            ['name' => 'agent_commission', 'type_id' => $typePercent->id, 'value' => 5],
            ['name' => 'agent_split', 'type_id' => $typePercent->id, 'value' => 70, 'lock_type' => true],
            ['name' => 'mc_split', 'type_id' => $typePercent->id, 'value' => 30, 'lock_type' => true],
            ['name' => 'agent_cap', 'type_id' => $typeDollar->id, 'value' => 50000, 'lock_type' => true],

        ];

        foreach ($attributes as $attr) {
            $attr['name_translation'] = 'financial.'.$attr['name'];
            FinancialAttribute::create($attr);
        }

        foreach (Region::all() as $region) {
            $financialAttrs = FinancialAttribute::all();
            foreach ($financialAttrs as $financialAttr) {
                $attr = [
                    'financial_attribute_id' => $financialAttr->id,
                    'region_id' => $region->id,
                    'type_id' => $financialAttr->type_id,
                    'value' => $financialAttr->value,
                ];
                CustomFinancialAttribute::create($attr);
            }
        }
    }
}
