<?php

namespace ecoughtry\NovaShield\Lib;

use ecoughtry\NovaShield\Contracts\SyncPermissionHook as SyncPermissionHookContract;
use Illuminate\Support\LazyCollection;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Permission;

class DefaultPermissionHook implements SyncPermissionHookContract
{
    /**
     * Sync permissions to a role
     *
     * @param  array<int,string>  $permissions
     * @return void
     */
    public function __invoke(Role $role, array $permissions)
    {
        Permission::query()->upsert(
            LazyCollection::make($permissions)
                ->map(function ($permission) use (&$role) {
                    return [
                        'name' => $permission,
                        'guard_name' => $role->guard_name,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })->toArray(),
            ['name', 'guard_name'],
            ['name', 'guard_name'],
        );

        $role->syncPermissions($permissions);
    }
}
