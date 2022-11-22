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
            'name' => 'city_admin',
            'email' => 'city_admin@email.com',
            'password' => Hash::make('password'),
            'role_id' => User::getRoleID('city_admin'),
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

        DB::table('users')->insert([
            'name' => 'Tech1',
            'email' => 'Tech1@email.com',
            'password' => Hash::make('password'),
            'role_id' => User::getRoleID('technician'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Tech2',
            'email' => 'Tech2@email.com',
            'password' => Hash::make('password'),
            'role_id' => User::getRoleID('technician'),
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

        $jack = new User([
            'name' => 'Jack',
            'email' => 'jack@email.com',
            'password' => Hash::make('password'),
        ]);
        $jack->setRole('technician');
        $jack->save();

        $zoe = new User([
            'name' => 'Zoe',
            'email' => 'zoe@email.com',
            'password' => Hash::make('password'),
        ]);
        $zoe->setRole('city_admin');
        $zoe->save();
    }
}
