<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name'  => 'admin',
            'email' => 'admin@mail.com',
            'password'  => bcrypt('password')
        ])->assignRole('admin');

        UserFactory::new()->count(10)->create();
    }
}
