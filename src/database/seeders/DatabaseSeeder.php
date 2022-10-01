<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
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
         User::create([
             'first_name' => 'ADMIN',
             'last_name' => 'Admin',
             'email' => 'admin@groupbwt.com',
             'password' => bcrypt('12345678'),
             'role' => 'ADMIN',
             'birthdate' => '2022-09-22 00:00:00',
             'countries' => 'Ukraine',
             'phone' => '123456789',
        ]);

         User::create([
             'first_name' => 'LISTENER',
             'last_name' => 'Listener',
             'email' => 'l@groupbwt.com',
             'password' => bcrypt('12345678'),
             'role' => 'LISTENER',
             'birthdate' => '2022-09-22 00:00:00',
             'countries' => 'Ukraine',
             'phone' => '123456789',
         ]);

         User::create([
             'first_name' => 'ANNOUNCER',
             'last_name' => 'Announcer',
             'email' => 'a@groupbwt.com',
             'password' => bcrypt('12345678'),
             'role' => 'ANNOUNCER',
             'birthdate' => '2022-09-22 00:00:00',
             'countries' => 'Ukraine',
             'phone' => '123456789',
         ]);
    }
}
