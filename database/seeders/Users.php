<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Saad Usmani',
            'email' => 'hsusmani@live.com',
            'password' => bcrypt('123456'),
            'preferred_currency' => 'egp',
            'preferred_language' => 'eng',
        ]);
        User::create([
            'name' => 'Hazam',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'preferred_currency' => 'egp',
            'preferred_language' => 'eng',
        ]);
    }
}
