<?php

namespace App\Helpers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AccessManagement
{
    public static function createRoleAssignUser($name,User $user)
    {       
      $role = Role::create(['name' => $name]);
      $user->assignRole($role);
      self::assignPermissionToRole($role);
    }

    /**
     * Assign permission to roles
     */
    public static function assignPermissionToRole(Role $role){

        self::generatePermissions(); //create all permissions first
        
        switch ($role->name) {
            case 'admin':
            self::giveAdminPermission($role);
            break;

            case 'hr':
            self::giveHrPermission($role);
            break;

            case 'supervisor':
            self::giveSupervisorPermission($role);
            break;

            case 'employee':
            self::giveEmployeePermission($role);
            break;
            
            default:
            return 'Unknown role name. Permission not handled';
            break;
        }

    }

    /**
     * Give Admin permissions
     */
    public static function giveAdminPermission(Role $role){
      $role->givePermissionTo([
            'password_reset',
            'apply_for_leave',
            'approve_leave',
            'edit_leave',
            'delete_leave',
            'edit_profile' ,
            'view_dependants',
            'add_dependant',
            'delete_dependant',
            'create_employee',
            'create_asset',
            'edit_asset',
            'edit_employee',
            'approve_employee',
            'delete_employee',
            'suspend_employee',
            'view_payslips',
            'create_notices',
            'create_shift',
            'view_shift',
            'view_salaries',
            'manage_leave',
            'view_payroll',
            'edit_payroll',
            'approve_payroll',
            'delete_payroll',
            'verify_reg_details',
            
            'edit_company'
          ]);
    }

    /**
     * Give Hr permissions
     */
    public static function giveHrPermision(Role $role){
        $role->givePermissionTo([
            'password_reset',
            'apply_for_leave',
            'approve_leave',
            'edit_leave',
            'delete_leave',
            'edit_profile',
            'view_dependants',
            'add_dependant',
            'delete_dependant',
            'create_employee',
            'edit_employee',
            'view_payslips',
            'create_notices',
            'create_shift', 
            'view_shift',
            'view_salaries',
            'manage_leave',
            'view_payroll',
            'edit_payroll',
            'approve_payroll',
            'verify_reg_details',

            'delete_payroll',
            'edit_company'
        ]);
    }

    /**
     * Give supervisor permissions
     */
    public static function giveSupervisorPermission(Role $role){
        $role->givePermissionTo([
            'password_reset',
            'apply_for_leave',
            'approve_leave',
            'edit_leave',
            'edit_profile', 
            'view_dependants',
            'add_dependant',
            'delete_dependant',
            'edit_employee',
            'view_payslips',
            'create_notices',
            'create_shift', 
            'verify_reg_details',

            'view_shift'
        ]);
    }

    /**
     * Give employee permissions
     */
    public static function giveEmployeePermission(){
        $role->givePermissionTo([
            'password_reset',
            'apply_for_leave',
            'edit_profile' ,
            'view_dependants',
            'add_dependant',
            'delete_dependant',
            'View_payslips',
            'create_resigation'
        ]);
    }

    /**
     * Genereate role permissions
     */
    protected static function generatePermissions()
    {   
        Permission::firstOrCreate(['name'=>'password_reset']);
        Permission::firstOrCreate(['name'=>'view_salaries']);           
        Permission::firstOrCreate(['name'=>'view_payroll']);           
        Permission::firstOrCreate(['name'=>'edit_payroll']);           
        Permission::firstOrCreate(['name'=>'approve_payroll']);           
        Permission::firstOrCreate(['name'=>'delete_payroll']);           
        Permission::firstOrCreate(['name'=>'apply_for_leave']);
        Permission::firstOrCreate(['name'=>'approve_leave']);
        Permission::firstOrCreate(['name'=>'edit_leave']);
        Permission::firstOrCreate(['name'=>'delete_leave']);
        Permission::firstOrCreate(['name'=>'edit_profile' ]);
        Permission::firstOrCreate(['name'=>'view_dependants']);
        Permission::firstOrCreate(['name'=>'add_dependant']);
        Permission::firstOrCreate(['name'=>'delete_dependant']);
        Permission::firstOrCreate(['name'=>'create_employee']);
        Permission::firstOrCreate(['name'=>'edit_employee']);
        Permission::firstOrCreate(['name'=>'approve_employee']);
        Permission::firstOrCreate(['name'=>'suspend_employee']);
        Permission::firstOrCreate(['name'=>'delete_employee']);
        Permission::firstOrCreate(['name'=>'view_payslips']);
        Permission::firstOrCreate(['name'=>'create_notices']);
        Permission::firstOrCreate(['name'=>'create_shift']);
        Permission::firstOrCreate(['name'=>'view_shift']);            
        Permission::firstOrCreate(['name'=>'create_resigation']);
        Permission::firstOrCreate(['name'=>'manage_leave']);
        Permission::firstOrCreate(['name'=>'verify_reg_details']);
        Permission::firstOrCreate(['name'=>'create_asset']);
        Permission::firstOrCreate(['name'=>'edit_asset']);

        Permission::firstOrCreate(['name'=>'edit_company']);

    }
}