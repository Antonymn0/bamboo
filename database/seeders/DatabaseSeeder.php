<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\Constants;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        /*$disabilities = Constants::disabilities();
        foreach($disabilities as $disability )
            \App\Models\Setting::factory(1)->create(['name'=>$disability]);*/
        \App\Models\Department::factory(5)->create();
      //  \App\Models\FormField::factory(1)->create();
        
    }
}
