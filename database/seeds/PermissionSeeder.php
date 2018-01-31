<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Team/Group level */

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'create_transaction';
        $permission->display_name = 'Create Transaction';
        $permission->description = 'create transaction';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'update_transaction';
        $permission->display_name = 'Update Transaction';
        $permission->description = 'update transaction';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'delete_transaction';
        $permission->display_name = 'Delete Transaction';
        $permission->description = 'delete transaction';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'upload_transaction';
        $permission->display_name = 'Upload Transaction';
        $permission->description = 'upload transaction';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'withdraw_transaction';
        $permission->display_name = 'Withdraw Transaction';
        $permission->description = 'withdraw transaction';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'associate_transaction_location';
        $permission->display_name = 'Associate Transaction Location';
        $permission->description = 'associate transaction location';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'view_team_report';
        $permission->display_name = 'View Team Report';
        $permission->description = 'view team report';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'view_own_report';
        $permission->display_name = 'View Own Report';
        $permission->description = 'view own report';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'alias_as_team_member';
        $permission->display_name = 'Alias As Team Member';
        $permission->description = 'alias as team member';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'create_payment';
        $permission->display_name = 'Create Payment';
        $permission->description = 'create payment';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'update_payment';
        $permission->display_name = 'Update Payment';
        $permission->description = 'update payment';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'delete_payment';
        $permission->display_name = 'Delete Payment';
        $permission->description = 'delete payment';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'create_referral';
        $permission->display_name = 'Create Referral';
        $permission->description = 'create referral';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'update_referral';
        $permission->display_name = 'Update Referral';
        $permission->description = 'update referral';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'delete_referral';
        $permission->display_name = 'Delete Referral';
        $permission->description = 'delete referral';
        $permission->save();



        /* MC level */

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'manage_team';
        $permission->display_name = 'Manage Team';
        $permission->description = 'manage team';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'manage_user';
        $permission->display_name = 'Manage User';
        $permission->description = 'manage user';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'approve_transaction';
        $permission->display_name = 'Approve/Reject Transaction';
        $permission->description = 'approve/reject transaction';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'approve_payment';
        $permission->display_name = 'Approve/Reject Payment';
        $permission->description = 'approve/reject payment';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'approve_referral';
        $permission->display_name = 'Approve/Reject Referral';
        $permission->description = 'approve/reject referral';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'add_mc_agent';
        $permission->display_name = 'Add/Remove MC Agent';
        $permission->description = 'add/remove MC agent';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'move_mc_agent';
        $permission->display_name = 'Move MC Agent';
        $permission->description = 'Move MC agent';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'view_own_financial';
        $permission->display_name = 'View Own Financial';
        $permission->description = 'view own financial';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'view_mc_report';
        $permission->display_name = 'View MC Report';
        $permission->description = 'view MC report';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'create_agent_financial';
        $permission->display_name = 'Create Agent Financial';
        $permission->description = 'create agent financial';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'update_agent_financial';
        $permission->display_name = 'Update agent Financial';
        $permission->description = 'update agent financial';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'delete_agent_financial';
        $permission->display_name = 'Delete Agent Financial';
        $permission->description = 'delete agent financial';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'freeze_mc';
        $permission->display_name = 'Freeze MC';
        $permission->description = 'freeze MC';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'manage_location';
        $permission->display_name = 'Manage Location';
        $permission->description = 'manage location';
        $permission->save();



        /* Region level */

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'freeze_region';
        $permission->display_name = 'Freeze Region';
        $permission->description = 'freeze region';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'view_region_report';
        $permission->display_name = 'View Region Report';
        $permission->description = 'view region report';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'manage_mc';
        $permission->display_name = 'Manage MC';
        $permission->description = 'manage MC';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'manage_additional_transaction_attributes';
        $permission->display_name = 'Manage Additional Transaction Attributes';
        $permission->description = 'manage additional transaction attributes';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'view_region_financial';
        $permission->display_name = 'View Region Financial';
        $permission->description = 'view region financial';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'create_mc_financial';
        $permission->display_name = 'Create MC Financial';
        $permission->description = 'create MC financial';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'update_mc_financial';
        $permission->display_name = 'Update MC Financial';
        $permission->description = 'update MC financial';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'delete_mc_financial';
        $permission->display_name = 'Delete MC Financial';
        $permission->description = 'delete MC financial';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'manage_language_translation';
        $permission->display_name = 'Manage Language Translation';
        $permission->description = 'manage language translation';
        $permission->save();



        /* KWRI level */

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'manage_region';
        $permission->display_name = 'Manage Region';
        $permission->description = 'manage region';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'unlock_transaction';
        $permission->display_name = 'Unlock Transaction';
        $permission->description = 'unlock transaction';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'view_kwri_report';
        $permission->display_name = 'View KWRI Report';
        $permission->description = 'view KWRI report';
        $permission->save();

        $permission = new \KW\Transactions\Models\Permission();
        $permission->name = 'export_report';
        $permission->display_name = 'Export Report';
        $permission->description = 'export report';
        $permission->save();

    }
}
