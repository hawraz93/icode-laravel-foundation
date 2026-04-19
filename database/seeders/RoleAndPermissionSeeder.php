<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $guard = 'web';

        $permissions = [
            'view users',
            'manage roles',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, $guard);
        }

        $adminRole = Role::findOrCreate('admin', $guard);
        $adminRole->syncPermissions(
            Permission::query()
                ->whereIn('name', $permissions)
                ->where('guard_name', $guard)
                ->get()
        );

        $user = User::query()->where('email', 'hawraz@gmail.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
