<?php

namespace Database\Seeders;

use App\Models\GuestMemberShips;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuestMembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guestMemberships = [
            [
                'name' => 'Basic',
                'spending_required' => 0,
                'point_required' => 0,
                'discount' => 0.5,
            ],
            [
                'name' => 'Bronze',
                'spending_required' => 250,
                'point_required' => 500,
                'discount' => 2.5,
            ],
            [
                'name' => 'Silver',
                'spending_required' => 1000,
                'point_required' => 2000,
                'discount' => 5,
            ],
            [
                'name' => 'Gold',
                'spending_required' => 5000,
                'point_required' => 10000,
                'discount' => 7.5,
            ],
            [
                'name' => 'Platinum',
                'spending_required' => 10000,
                'point_required' => 20000,
                'discount' => 10,
            ],
            [
                'name' => 'Diamond',
                'spending_required' => 20000,
                'point_required' => 40000,
                'discount' => 12.5,
            ],
            [
                'name' => 'Elite',
                'spending_required' => 40000,
                'point_required' => 80000,
                'discount' => 15,
            ],
            [
                'name' => 'VIP',
                'spending_required' => 80000,
                'point_required' => 160000,
                'discount' => 17.5,
            ],
            [
                'name' => 'Royal',
                'spending_required' => 200000,
                'point_required' => 500000,
                'discount' => 20,
            ],
            [
                'name' => 'Legend',
                'spending_required' => 500000,
                'point_required' => 1000000,
                'discount' => 25,
            ],
        ];

        foreach ($guestMemberships as $guestMembership) {
            GuestMemberShips::factory()->create($guestMembership);
        }
    }
}
