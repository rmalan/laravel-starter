<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'group_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@bkd.test',
            'username' => 'admin',
            'password' => Hash::make('admin'),
        ]);
    }
}