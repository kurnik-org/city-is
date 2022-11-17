<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
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
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('password'),
            'role_id' => User::getRoleID('admin'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Chris Bacon',
            'email' => 'chris@email.com',
            'password' => Hash::make('password'),
            'role_id' => User::getRoleID('citizen'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $mia = new User([
            'name' => 'Mia Eggs',
            'email' => 'mia@email.com',
            'password' => Hash::make('password'),
        ]);
        $mia->setRole('citizen');
        $mia->save();
    }
}
