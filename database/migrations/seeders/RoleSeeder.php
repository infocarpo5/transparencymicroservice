<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'admin'
            ],
            [
                'name' => 'student'
            ],
            [
                'name' => 'parent'
            ],
        ];
        foreach($data as $item) {
            Role::updateOrCreate($item);
        }
    }
}
