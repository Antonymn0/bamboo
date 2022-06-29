<?php

namespace App\Http\Controllers\Web\Preferences\AccessLevels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsController extends Controller
{
    /**
     * Toggle role permissions
     */
    public function toggleRolePermissions(Request $request, User $user){
        $request->validate([
            'role_id'=> 'required|integer',
            'permission_id'=> 'required|integer',
        ]);

        $role = Role::find($request->role_id);
        $permission = Permission::find($request->permission_id);
       
       if( ! $role->hasPermissionTo($permission->name) ) $role->givePermissionTo($permission->name);
        else $role->revokePermissionTo($permission->name);
        

        $data['roles'] =  Role::with('permissions')->get();
        $data['permissions'] = Permission::all();

        return response()->json([
            'success' => true,
            'message' => 'Success, Role permission toggled',
            'data' => $data,
        ]);
    }

    /**
     * Toggle role permissions
     */
    public function toggleUserPermissions(Request $request, User $user){
        $request->validate([
            'user_id'=> 'required|integer',
            'permission_id'=> 'required|integer',
        ]);

        $permission_user = User::findOrFail($request->user_id);
        $permission = Permission::find($request->permission_id);

       if( $permission_user->hasPermissionTo($permission->name) )   $permission_user->revokePermissionTo($permission->name);         
        else  $permission_user->givePermissionTo($permission->name);      

        $data['user_permissions'] =  $permission_user->getDirectPermissions();
        $data['permissions'] = Permission::all();

        return response()->json([
            'success' => true,
            'message' => 'Success, user permission toggled',
            'data' => $data,
        ]);
    }

    /**
     * Get user permissions
     */
    public function getUserPermissions(Request $request, User $user){     
        $data['user_permissions'] =  $user->getDirectPermissions();
        $data['permissions'] = Permission::all();

        return response()->json([
            'success' => true,
            'message' => 'Success, user permissions fetched',
            'data' => $data,
        ]);
    }
}
