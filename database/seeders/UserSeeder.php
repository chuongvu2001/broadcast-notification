<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = [
            [
                'name' => 'User1',
                'email' => 'user1@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'User2',
                'email' => 'user2@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'User3',
                'email' => 'user3@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'User4',
                'email' => 'user4@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'User5',
                'email' => 'user5@gmail.com',
                'password' => bcrypt('12345678')
            ]
        ];
        User::insert($user);
    }
}
