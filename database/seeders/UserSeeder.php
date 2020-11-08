<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        User::firstOrCreate([
            'name'      => 'User 1',
            'email'     => 'webinarsiuser@yopmail.com',
            'password'  => Hash::make('webinarsiuser'),
            'is_active' => '1'
        ]);
    }
}
