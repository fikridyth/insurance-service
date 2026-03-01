<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        DB::table('users')->insert([
            [
                'name' => 'Fikri',
                'email' => 'fikri@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hidayat',
                'email' => 'hidayat@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Verifier',
                'email' => 'verifier@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'verifier',
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Approver',
                'email' => 'approver@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'approver',
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
