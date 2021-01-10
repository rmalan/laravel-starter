<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            'name' => 'Admin',
            'email' => 'admin@laravel-starter.test',
            'username' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),            
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('model_has_roles')->insert(
            [
                'role_id' => 1,
                'model_type' => 'App\Models\User',
                'model_id' => 1
            ]
        );
    }
}
