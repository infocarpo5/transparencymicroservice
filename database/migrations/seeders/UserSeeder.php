<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
            'full_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '0765454334',
            //'remember_token' => Str::random(10),
            'role_id' => 1,
            'uuid' => \Str::uuid(),
            ]
        ];
foreach ($data as $row) {
    User::updateOrCreate($row);
}
    }
}
