<?php

use Illuminate\Database\Seeder;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = new \KW\Transactions\Models\TaskType();
        $type->name = 'transaction_submitted';
        $type->name_translation = 'task.transaction_submitted';
        $type->save();

    }
}
