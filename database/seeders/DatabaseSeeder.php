<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use App\Models\JobVacancy;
use App\Models\Company;
use App\Models\JobTraining;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        Company::factory(20)->create();
        JobVacancy::factory(20)->create();
        JobTraining::factory(20)->create();
        
        //$this->call(AdminSeeder::class);
    }
}
