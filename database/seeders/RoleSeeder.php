<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate([
            'name'      => 'admin',
            'guard_name'    => 'sanctum'
        ])->givePermissionTo(Permission::all());

        Role::firstOrCreate([
            'name'  => 'head-of-family',
            'guard_name'    => 'sanctum',

        ])->givePermissionTo([
            'dashboard-menu',

            'family-member-menu',
            'family-member-list',
            'family-member-create',
            'family-member-edit',
            'family-member-delete',

            'social-assistance-menu',
            'social-assistance-list',

            'social-assistance-recipient-menu',
            'social-assistance-recipient-list',
            'social-assistance-recipient-create',
            'social-assistance-recipient-edit',
            'social-assistance-recipient-delete',

            'event-menu',
            'event-list',

            'event-participant-menu',
            'event-participant-list',
            'event-participant-create',
            'event-participant-edit',
            'event-participant-delete',

            'development-menu',
            'development-list',

            'development-applicant-menu',
            'development-applicant-list',
            'development-applicant-create',
            'development-applicant-edit',
            'development-applicant-delete',

            'profile-menu'
        ]);
    }
}
