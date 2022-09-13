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
        DB::table('admins')->delete();

        $admins = array(
            array('email' => 'admin@groupbwt.com','password' => '12345678'),
        );
        DB::table('admins')->insert($admins);
    }
}
