<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* KWRI level */

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'super_admin';
        $role->display_name = 'Super Admin';
        $role->description = 'super user';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('KWRI'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'kwri_support';
        $role->display_name = 'KWRI Support';
        $role->description = 'KWRI Support';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('KWRI'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'kwri_business_admin';
        $role->display_name = 'KWRI Business Admin';
        $role->description = 'KWRI Business Admin';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('KWRI'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'kwri_executive';
        $role->display_name = 'KWRI Executive';
        $role->description = 'KWRI Executive';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('KWRI'));



        /* Region level */

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'region_admin';
        $role->display_name = 'Region Admin';
        $role->description = 'region admin';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('Region'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'region_director';
        $role->display_name = 'Region Director';
        $role->description = 'region director';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('Region'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'region_staff';
        $role->display_name = 'Region Staff';
        $role->description = 'region staff';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('Region'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'region_tech_manager';
        $role->display_name = 'Region Tech Manager';
        $role->description = 'region tech manager';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('Region'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'region_op';
        $role->display_name = 'Region OP';
        $role->description = 'region OP';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('Region'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'region_mca';
        $role->display_name = 'Region MCA';
        $role->description = 'region MCA';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('Region'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'region_investor';
        $role->display_name = 'Region Investor';
        $role->description = 'region investor';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('Region'));


        /* MC level */

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'mc_op';
        $role->display_name = 'MC OP';
        $role->description = 'MC OP';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('MC'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'mc_investor';
        $role->display_name = 'MC Investor';
        $role->description = 'MC investor';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('MC'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'mc_team_leader';
        $role->display_name = 'MC Team Leader';
        $role->description = 'MC team leader';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('MC'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'mc_mca';
        $role->display_name = 'MC MCA';
        $role->description = 'MC MCA';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('MC'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'mc_staff';
        $role->display_name = 'MC Staff';
        $role->description = 'MC staff';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('MC'));

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'mc_tech_coordinator';
        $role->display_name = 'MC Tech Coordinator';
        $role->description = 'MC tech coordinator';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions('MC'));



        /* Team/Group level */

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'lead_agent';
        $role->display_name = 'Lead Agent';
        $role->description = 'lead agent';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions());

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'agent';
        $role->display_name = 'Agent';
        $role->description = 'agent';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions());

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'producing_team_member';
        $role->display_name = 'Producing Team Member';
        $role->description = 'producing team member';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions());

        $role = new \KW\Transactions\Models\Role();
        $role->name = 'non_producing_team_member';
        $role->display_name = 'Non-producing Team Member';
        $role->description = 'non-producing team member';
        $role->save();
        $role->permissions()->attach($this->getRolePermissions());
    }

    private function getRolePermissions($level=null, $roleName=null)
    {
        $perms = [];

        switch ($level) {
            case 'KWRI':
                $perms = array_merge($perms, [
                    'manage_region',
                    'unlock_transaction',
                    'view_kwri_report',
                    'export_report'
                ]);

            case 'Region':
                $perms = array_merge($perms, [
                    'freeze_region',
                    'view_region_report',
                    'manage_mc',
                    'manage_additional_transaction_attributes',
                    'view_region_financial',
                    'create_mc_financial',
                    'update_mc_financial',
                    'delete_mc_financial',
                    'manage_language_translation'
                ]);

            case 'MC':
                $perms = array_merge($perms, [
                    'manage_team',
                    'manage_user',
                    'approve_transaction',
                    'approve_payment',
                    'approve_referral',
                    'add_mc_agent',
                    'move_mc_agent',
                    'view_own_financial',
                    'view_mc_report',
                    'create_agent_financial',
                    'update_agent_financial',
                    'delete_agent_financial',
                    'freeze_mc',
                    'manage_location',
                ]);

            case 'Team/Group':

            default:
                $perms = array_merge($perms, [
                    'create_transaction',
                    'update_transaction',
                    'delete_transaction',
                    'upload_transaction',
                    'withdraw_transaction',
                    'associate_transaction_location',
                    'view_team_report',
                    'view_own_report',
                    'alias_as_team_member',
                    'create_payment',
                    'update_payment',
                    'delete_payment',
                    'create_referral',
                    'update_referral',
                    'delete_referral',
                ]);
                break;
        }

        $permissions = \KW\Transactions\Models\Permission::whereIn('name', $perms)->get();
        return $permissions;
    }
}
