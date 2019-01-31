<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountUser extends Model {

    protected $table = 'account_user';

    protected $appends = [
        'all_permission_names',
        'all_role_names'
    ];

    public function account()
    {
        return $this->hasOne('App\Models\Account');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'account_user_role', 'account_user_id', 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'account_user_permission', 'account_user_id', 'permission_id');
    }

    public function getAllPermissionNamesAttribute()
    {
        $accountUser = $this;
        $isUserSuperAdmin = $accountUser->hasRole('super-admin');
        if ($isUserSuperAdmin) {
            $allPermissionNames = Permission::get()->pluck('name');
        } else {
            $directPermissionNames = $accountUser->permissions->pluck('name');
            $rolePermissionNames = $accountUser->roles()->with('permissions')->get()->pluck('permissions')->flatten(1)->pluck('name');
            $allPermissionNames = $directPermissionNames->merge($rolePermissionNames)->unique();
        }
        return $allPermissionNames->all();
    }

    public function getAllRoleNamesAttribute()
    {
        $accountUser = $this;
        $assignedRoleNames = $accountUser->roles()->pluck('name')->all();
        $isUserSuperAdmin = in_array('super-admin', $assignedRoleNames);
        return $isUserSuperAdmin ? Role::get()->pluck('name')->all() : $assignedRoleNames;
    }

    public function assignRole($roleName)
    {
        $accountUser = $this;
        if (is_array($roleName)) {
            $roles = Role::whereIn('name', $roleName)->select('id')->get();
            $roleIds = $roles->pluck('id');
            $accountUser->roles()->syncWithoutDetaching($roleIds);
        } else {
            $role = Role::where('name', $roleName)->select('id')->get();
            $roleId = $role->pluck('id');
            $accountUser->roles()->syncWithoutDetaching($roleId);
        }
    }

    public function givePermissionTo($permissionName)
    {
        $accountUser = $this;
        if (is_array($permissionName)) {
            $permissions = Permission::whereIn('name', $permissionName)->select('id')->get();
            $permissionIds = $permissions->pluck('id');
            $accountUser->permissions()->syncWithoutDetaching($permissionIds);
        } else {
            $permission = Permission::where('name', $permissionName)->select('id')->get();
            $permissionId = $permission->pluck('id');
            $accountUser->permissions()->syncWithoutDetaching($permissionId);
        }
    }

    public function hasPermissionTo($permissionName)
    {
        $accountUser = $this;
        $isUserSuperAdmin = $accountUser->hasRole('super-admin');
        $hasPermission = $isUserSuperAdmin || in_array($permissionName, $accountUser->all_permission_names);
        return $hasPermission;
    }

    public function hasRole($roleName)
    {
        $accountUser = $this;
        $hasRole = in_array($roleName, $accountUser->all_role_names);
        return $hasRole;
    }
}
