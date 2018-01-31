<?php

use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = new \KW\Transactions\Models\TransactionType();
        $type->name = 'buyer side';
        $type->name_translation = 'transaction.buyer_side';
        $type->save();

        $type = new \KW\Transactions\Models\TransactionType();
        $type->name = 'seller side';
        $type->name_translation = 'transaction.seller_side';
        $type->save();

        $type = new \KW\Transactions\Models\TransactionType();
        $type->name = 'both';
        $type->name_translation = 'transaction.both';
        $type->save();

        $type = new \KW\Transactions\Models\TransactionType();
        $type->name = 'lease';
        $type->name_translation = 'transaction.lease';
        $type->save();

        $type = new \KW\Transactions\Models\TransactionType();
        $type->name = 'referral';
        $type->name_translation = 'transaction.referral';
        $type->save();

        $type = new \KW\Transactions\Models\TransactionType();
        $type->name = 'other';
        $type->name_translation = 'transaction.other';
        $type->save();
    }
}
