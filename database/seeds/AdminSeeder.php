<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->delete();

        $admin = array('first_name' => 'Iryna', 'last_name' => 'Shumovska','email' => 'admin@groupbwt.com','password' => '$2y$10$N/5UrPVKndZ47IiOZsSlE..iuXp8DWIYGLG4ms6ujI8p/OmFUJHbK', 'role' => 'ADMIN', 'birthdate' => '1997-05-31T12:00', 'countries' => '223', 'phone'=>'676617881');
        DB::table('admin')->insert($admin);
    }
}
