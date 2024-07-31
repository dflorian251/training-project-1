<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists = User::where('email', 'admin@test.com')->exists();
        if ($exists) {
            return ;
        }

        $password = env('ADMIN_PASSWORD');
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'role' => 'admin',
            'password' => Hash::make($password),
        ]);
    }
}
