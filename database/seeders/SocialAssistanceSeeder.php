<?php

namespace Database\Seeders;

use Database\Factories\SocialAssistanceFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialAssistanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        SocialAssistanceFactory::new()->count(50)->create();
    }
}