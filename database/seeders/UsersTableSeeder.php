<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                 => 1,
                'name'               => 'Admin',
                'email'              => 'admin@admin.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'approved'           => 1,
                'verified'           => 1,
                'verified_at'        => '2022-12-12 04:44:16',
                'verification_token' => '',
            ],
            [
                'id'                 => 2,
                'name'               => 'Adminstrator',
                'email'              => 'user@gmail.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'approved'           => 1,
                'verified'           => 1,
                'verified_at'        => '2022-12-12 04:44:16',
                'verification_token' => '',
            ],
        ];

        User::insert($users);
    }
}
