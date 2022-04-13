<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modes\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'	=> 'admin',
            'email'	=> 'admin@gmail.com',
            'password'	=> bcrypt('admin123'),
            'role_id' => 1,
        ]);
    }
}
