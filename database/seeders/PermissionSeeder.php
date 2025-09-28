<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        'dashboard' => [
            'menu'
        ],

        'head-of-family'    => [
            'menu',
            'list',
            'create',
            'edit',
            'delete'
        ],

        'family-member'    => [
            'menu',
            'list',
            'create',
            'edit',
            'delete'
        ],

        'social-assistance'    => [
            'menu',
            'list',
            'create',
            'edit',
            'delete'
        ],

        'social-assistance-recipient'    => [
            'menu',
            'list',
            'create',
            'edit',
            'delete'
        ],

        'event'    => [
            'menu',
            'list',
            'create',
            'edit',
            'delete'
        ],

        'event-participant'    => [
            'menu',
            'list',
            'create',
            'edit',
            'delete'
        ],

        'development'    => [
            'menu',
            'list',
            'create',
            'edit',
            'delete'
        ],

        'development-applicant'    => [
            'menu',
            'list',
            'create',
            'edit',
            'delete'
        ],

        'profile'    => [
            'menu',
            'create',
            'edit',

        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->permissions as $key => $value) {
            foreach ($value as $permission) {
                Permission::firstOrCreate([
                    'name'      => $key . '-' . $permission,
                    'guard_name' => 'sanctum'
                ]);
            }
        }
    }
}
