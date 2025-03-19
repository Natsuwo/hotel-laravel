<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Admin Role',
                'is_active' => true,
                'priority' => 100,
            ],
            [
                'name' => 'User',
                'description' => 'User Role',
                'is_active' => true,
                'priority' => 0,
            ],
        ];

        foreach ($roles as $role) {
            Roles::factory()->create($role);
            // Roles::create($role);
        }
    }
}
