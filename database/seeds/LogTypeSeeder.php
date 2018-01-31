<?php

use Illuminate\Database\Seeder;

class LogTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = new \KW\Transactions\Models\LogType();
        $type->name = 'update';
        $type->save();

        $type = new \KW\Transactions\Models\LogType();
        $type->name = 'delete';
        $type->save();

        $type = new \KW\Transactions\Models\LogType();
        $type->name = 'create';
        $type->save();

        $type = new \KW\Transactions\Models\LogType();
        $type->name = 'error';
        $type->save();

        $type = new \KW\Transactions\Models\LogType();
        $type->name = 'information';
        $type->save();

        $type = new \KW\Transactions\Models\LogType();
        $type->name = 'debug';
        $type->save();
    }
}
