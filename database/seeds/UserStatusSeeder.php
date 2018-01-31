<?php

use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = new \KW\Transactions\Models\UserStatus();
        $status->name = 'active';
        $status->name_translation = 'user.active';
        $status->save();

        $status = new \KW\Transactions\Models\UserStatus();
        $status->name = 'inactive';
        $status->name_translation = 'user.inactive';
        $status->save();
    }
}
