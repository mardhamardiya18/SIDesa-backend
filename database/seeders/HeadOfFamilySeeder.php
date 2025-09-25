<?php

namespace Database\Seeders;

use App\Models\FamilyMember;
use Database\Factories\FamilyMemberFactory;
use Database\Factories\HeadOfFamilyFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeadOfFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        UserFactory::new()->count(15)->create()->each(function ($user) {
            HeadOfFamilyFactory::new()->count(1)->create([
                'user_id' => $user->id,
            ]);

            FamilyMemberFactory::new()->count(3)->create([
                'user_id' => UserFactory::new()->create()->id,
                'head_of_family_id' => $user->headOfFamily->id,
            ]);
        });
    }
}