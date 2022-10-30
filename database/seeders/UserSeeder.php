<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    
    public function run()
    {
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@laravel.com',
                'password' => bcrypt('12345678'),
                'photo' => 'storage/img/man.png',
                'level_id' => '1',
            ],
            [
                'username' => 'andi',
                'email' => 'andi@laravel.com',
                'password' => bcrypt('12345678'),
                'photo' => 'storage/img/man.png',
                'level_id' => '2',
            ],
            [
                'username' => 'dodi',
                'email' => 'dodi@laravel.com',
                'password' => bcrypt('12345678'),
                'photo' => 'storage/img/man.png',
                'level_id' => '2',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
