<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'name' => 'Private balcony (where applicable)',
                'icon' => null,
                'type' => 'feature',
            ],
            [
                'name' => 'Work desk with ergonomic chair',
                'icon' => null,
                'type' => 'feature',
            ],
            [
                'name' => 'Spacious layout with a modern design',
                'icon' => null,
                'type' => 'feature',
            ],
            [
                'name' => 'Large windows offering city or garden views',
                'icon' => null,
                'type' => 'feature',
            ],
            [
                'name' => 'Room Service',
                'icon' => null,
                'type' => 'feature',
            ],
            [
                'name' => 'Complimentary bottled water',
                'icon' => null,
                'type' => 'amenity',
            ],
            [
                'name' => 'Coffee and tea making facilities',
                'icon' => null,
                'type' => 'amenity',
            ],
            [
                'name' => 'Luxury toiletries',
                'icon' => null,
                'type' => 'amenity',
            ],
            [
                'name' => 'Complimentary bottled water',
                'icon' => null,
                'type' => 'amenity',
            ],
            [
                'name' => 'Hairdryer',
                'icon' => null,
                'type' => 'amenity',
            ],
            [
                'name' => 'Premium bedding and linens',
                'icon' => null,
                'type' => 'amenity',
            ],
            [
                'name' => 'Bathrobe and slippers',
                'icon' => null,
                'type' => 'amenity',
            ],
            [
                'name' => 'Ensuite bathroom with shower and bathtub',
                'icon' => null,
                'type' => 'amenity',
            ],
            [
                'name' => '24-hour room service',
                'icon' => null,
                'type' => 'amenity',
            ],
            [
                'name' => 'Air Conditioning',
                'icon' => 'mdi mdi-air-conditioner',
                'type' => 'facility',
            ],
            [
                'name' => 'Mini Fridge',
                'icon' => 'mdi mdi-fridge',
                'type' => 'facility',
            ],
            [
                'name' => 'Room Service',
                'icon' => 'mdi mdi-bell-ring',
                'type' => 'facility',
            ],
            [
                'name' => 'Hair Dryer',
                'icon' => 'mdi mdi-hair-dryer',
                'type' => 'facility',
            ],
            [
                'name' => 'Work Desk',
                'icon' => 'mdi mdi-desk',
                'type' => 'facility',
            ],
            [
                'name' => 'Coffee Maker',
                'icon' => 'mdi mdi-coffee',
                'type' => 'facility',
            ],
            [
                'name' => 'Telephone',
                'icon' => 'mdi mdi-phone',
                'type' => 'facility',
            ],
            [
                'name' => 'Shower',
                'icon' => 'mdi mdi-shower',
                'type' => 'facility',
            ],
            [
                'name' => 'Bathtub',
                'icon' => 'mdi mdi-bathtub',
                'type' => 'facility',
            ],
            [
                'name' => 'City View',
                'icon' => 'mdi mdi-city',
                'type' => 'facility',
            ],
            [
                'name' => 'Ocean View',
                'icon' => 'mdi mdi-waves',
                'type' => 'facility',
            ],
            [
                'name' => 'Balcony',
                'icon' => 'mdi mdi-balcony',
                'type' => 'facility',
            ],
            [
                'name' => 'King Size Bed',
                'icon' => 'mdi mdi-bed-king',
                'type' => 'facility',
            ],
            [
                'name' => 'Double Bed',
                'icon' => 'mdi mdi-bed-double',
                'type' => 'facility',
            ],
            [
                'name' => 'Single Bed',
                'icon' => 'mdi mdi-bed-single',
                'type' => 'facility',
            ],
            [
                'name' => 'Spa Access',
                'icon' => 'mdi mdi-spa',
                'type' => 'facility',
            ],
            [
                'name' => 'Fitness Center',
                'icon' => 'mdi mdi-dumbbell',
                'type' => 'facility',
            ],
            [
                'name' => 'Swimming Pool',
                'icon' => 'mdi mdi-pool',
                'type' => 'facility',
            ],
            [
                'name' => 'Parking Available',
                'icon' => 'mdi mdi-parking',
                'type' => 'facility',
            ],
            [
                'name' => 'Pet Friendly',
                'icon' => 'mdi mdi-paw',
                'type' => 'facility',
            ],
            [
                'name' => 'Non-Smoking Room',
                'icon' => 'mdi mdi-smoking-off',
                'type' => 'facility',
            ],
            [
                'name' => '24/7 Reception',
                'icon' => 'mdi mdi-clock-outline',
                'type' => 'facility',
            ],
        ];


        foreach ($features as $feature) {
            Feature::factory()->create($feature);
            // Feature::create($feature);
        }
    }
}
