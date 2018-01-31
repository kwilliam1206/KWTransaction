<?php

use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = new \KW\Transactions\Models\PaymentStatus();
        $status->name = 'draft';
        $status->name_translation = 'payment.draft';
        $status->save();
        $status = new \KW\Transactions\Models\PaymentStatus();
        $status->name = 'submitted';
        $status->name_translation = 'payment.submitted';
        $status->save();
        $status = new \KW\Transactions\Models\PaymentStatus();
        $status->name = 'approved';
        $status->name_translation = 'payment.approved';
        $status->save();
        $status = new \KW\Transactions\Models\PaymentStatus();
        $status->name = 'received';
        $status->name_translation = 'payment.received';
        $status->save();
        $status = new \KW\Transactions\Models\PaymentStatus();
        $status->name = 'cleared';
        $status->name_translation = 'payment.cleared';
        $status->save();
    }
}
