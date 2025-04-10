<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Jaafar',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '970591234567',
        ]);

        Admin::create([
            'name' => 'Jaafar',
            'username' => 'admin', // Add this!
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '970591234567',
            'super_admin' => true,
        ]);

    }
}
