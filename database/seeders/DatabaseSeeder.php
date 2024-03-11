<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // user
        \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        //customer category
        \App\Models\CustomerCategory::create([
            'name' => 'engineer',
            'user_id' => 1,
        ]);

        \App\Models\CustomerCategory::create([
            'name' => 'wholesaler',
            'user_id' => 1,
        ]);

        \App\Models\CustomerCategory::create([
            'name' => 'constructor',
            'user_id' => 1,
        ]);


        //unit
        \App\Models\ProductUnit::create([
            'name' => 'KG',
            'user_id' => 1,
        ]);

        \App\Models\ProductUnit::create([
            'name' => 'Liter',
            'user_id' => 1,
        ]);

        \App\Models\ProductUnit::create([
            'name' => 'Bosta',
            'user_id' => 1,
        ]);

    }
}
