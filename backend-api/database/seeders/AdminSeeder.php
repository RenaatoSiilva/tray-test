<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::truncate();

        User::firstOrCreate([
            'name'      =>  'Admin Tray',
            'email'     =>  'admin@tray.net',
            'password'  =>  bcrypt(123456789)
        ]);
    }
}
