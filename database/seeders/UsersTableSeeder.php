<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'          => "Superadmin",
                'gender'        => "male",
                'email'         => "superadmin@test.com",
                'phone_number'  => "08037683537",
                'role'          => "superadmin",
                "password"      => Hash::make("qwertyuiop"),
            ],
            [
                'name'          => "Admin001",
                'gender'        => "female",
                'email'         => "admin@test.com",
                'phone_number'  => "07051440103",
                'role'          => "admin",
                "password"      => Hash::make("qwertyuiop"),
            ],
            [
                'name'          => "Admin002",
                'gender'        => "male",
                'email'         => "admin@test.com",
                'phone_number'  => "08037600000",
                'role'          => "admin",
                "password"      => Hash::make("qwertyuiop"),
            ],
        ];
        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
