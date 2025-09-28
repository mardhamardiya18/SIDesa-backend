<?php

namespace Database\Seeders;

use App\Models\Development;
use App\Models\DevelopmentApplicant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevelopmentApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developments = Development::all();
        $users = User::all();

        foreach ($developments as $development) {
            foreach ($users as $user) {
                // Avoid duplicate applications
                if (!DevelopmentApplicant::where('development_id', $development->id)->where('user_id', $user->id)->exists()) {
                    DevelopmentApplicant::factory()->create([
                        'development_id' => $development->id,
                        'user_id' => $user->id,
                    ]);
                }
            }
        }
    }
}
