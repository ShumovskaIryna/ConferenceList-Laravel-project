<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\User::factory(40)->create();

         \App\Models\User::factory()->create([
             'first_name' => 'Iryna',
             'last_name' => 'Shumovska',
             'email' => 'admin@groupbwt.com',
         ]);
    }
}
