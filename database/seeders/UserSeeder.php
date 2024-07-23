<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // add users
        DB::table('users')->insert(
            [
                'name'=>'Ketan Kulkarni',
                'email'=>'ketan@carvingit.com',
                'password'=>Hash::make('SmartPass!@#'),
                'remember_token'=>0,
                'email_verified_at'=>NOW(),
                'created_at'=>NOW(),
                'updated_at'=>NOW(),
            ]
        );

        DB::table('users')->insert(
            [
                'name'=>'Shraddha Kulkarni',
                'email'=>'shraddha@carvingit.com',
                'password'=>Hash::make('SmartPass!@#'),
                'remember_token'=>0,
                'email_verified_at'=>NOW(),
                'created_at'=>NOW(),
                'updated_at'=>NOW(),
            ]);
        // make first user admin
        DB::table('user_roles')->insert(
            [
                'user_id'=>1,
                'role_id'=>1
            ]
        );
    }
}
