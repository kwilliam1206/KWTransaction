<?php

use Illuminate\Database\Seeder;

class TransactionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = new \KW\Transactions\Models\TransactionStatus();
        $status->name = 'draft';
        $status->name_translation = 'transaction.draft';
        $status->save();
        $status = new \KW\Transactions\Models\TransactionStatus();
        $status->name = 'submitted';
        $status->name_translation = 'transaction.submitted';
        $status->save();
        $status = new \KW\Transactions\Models\TransactionStatus();
        $status->name = 'rejected';
        $status->name_translation = 'transaction.rejected';
        $status->save();
        $status = new \KW\Transactions\Models\TransactionStatus();
        $status->name = 'accepted';
        $status->name_translation = 'transaction.accepted';
        $status->save();
        $status = new \KW\Transactions\Models\TransactionStatus();
        $status->name = 'withdrawn';
        $status->name_translation = 'transaction.withdrawn';
        $status->save();
        $status = new \KW\Transactions\Models\TransactionStatus();
        $status->name = 'pending';
        $status->name_translation = 'transaction.pending';
        $status->save();
        $status = new \KW\Transactions\Models\TransactionStatus();
        $status->name = 'completed';
        $status->name_translation = 'transaction.completed';
        $status->save();
    }
}
