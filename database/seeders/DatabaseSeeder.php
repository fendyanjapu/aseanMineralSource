<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        DB::table('users')->insert([
            'name' => 'Test User Admin',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'level_id' => '1',
            'jenis_user_id' => '1',
            'created_by' => 'Test User Admin',
        ]);

        DB::table('jenis_users')->insert([
            'jenis' => 'Asian Mining Source',
        ]);
        DB::table('jenis_users')->insert([
            'jenis' => 'Site',
        ]);

        DB::table('levels')->insert([
            'level' => 'IT',
        ]);
        DB::table('levels')->insert([
            'level' => 'Direksi Asean Mineral Source',
        ]);
        DB::table('levels')->insert([
            'level' => 'Checker Asean Mineral Source',
        ]);
        DB::table('levels')->insert([
            'level' => 'Operator Site',
        ]);
    }
}
