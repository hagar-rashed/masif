<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert(
            [
                'name' => 'مؤسس النظام',
                // 'user_name'=>'admin',
                'image'=>'b',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456789'),
                'isVerified' => 1,
            ]
        );
    }
}
