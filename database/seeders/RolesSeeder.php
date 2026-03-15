<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // User actions
        Permission::create(['name' => 'create posts', 'guard_name' => 'web']);
        Permission::create(['name' => 'create comments', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit posts', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit comments', 'guard_name' => 'web']);

        // Moderator actions
        Permission::create(['name' => 'delete comments', 'guard_name' => 'web']);
        Permission::create(['name' => 'lock posts', 'guard_name' => 'web']);
        Permission::create(['name' => 'pin posts', 'guard_name' => 'web']);
        Permission::create(['name' => 'ban users', 'guard_name' => 'web']);

        // Admin actions (optional if using role->givePermissionTo(Permission::all()))
        Permission::create(['name' => 'delete posts', 'guard_name' => 'web']);
        Permission::create(['name' => 'manage subforums', 'guard_name' => 'web']);
        Permission::create(['name' => 'manage tags', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete users', 'guard_name' => 'web']);

        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $moderator = Role::create(['name' => 'moderator', 'guard_name' => 'web']);
        $user = Role::create(['name' => 'user', 'guard_name' => 'web']);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $user->givePermissionTo([
            'create posts',
            'create comments',
            'edit posts',
            'edit comments',
        ]);

        $moderator->givePermissionTo([
            'delete comments',
            'lock posts',
            'pin posts',
            'ban users',
        ]);

        $admin->givePermissionTo(Permission::all());
    }
}
