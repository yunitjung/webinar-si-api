<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::firstOrCreate([
            'name'  => 'System Administrator',
            'email' => 'adminwebinarsi@yopmail.com',
            'password'  => Hash::make('adminwebinarsi'),
            'is_active' => '1'
        ]);
    }
}
