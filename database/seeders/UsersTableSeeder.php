<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $send_mail = false;

        $users = [
            [
                'name' => 'Jospy GOUDALO',
                'email' => 'jospygoudalo@gmail.com',
            ],
            [
                'name' => 'Yassine ',
                'email' => 'yassine@gmail.com',
            ],
        ];

        foreach ($users as $user_data) {
            $user = User::create([
                'name' => $user_data['name'],
                'email' => $user_data['email'],
                'password' => Hash::make("secret"),
            ]);
            dump($user_data['name']);
        }
    }
}
