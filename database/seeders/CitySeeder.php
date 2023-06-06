<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'country_id'    => 1,
                'name'          => 'Islamabad',
                'status'        => 1
            ],
            [
                'country_id'    => 1,
                'name'          => 'Lahore',
                'status'        => 1
            ],
            [
                'country_id'    => 1,
                'name'          => 'Karachi',
                'status'        => 1
            ],
            [
                'country_id'    => 1,
                'name'          => 'Hyderabad',
                'status'        => 1
            ],
            [
                'country_id'    => 2,
                'name'          => 'Bombay',
                'status'        => 1
            ],
            [
                'country_id'    => 2,
                'name'          => 'Mumbai',
                'status'        => 1
            ],
            [
                'country_id'    => 2,
                'name'          => 'Chennai',
                'status'        => 1
            ],
            [
                'country_id'    => 2,
                'name'          => 'Hyderabad',
                'status'        => 1
            ],
            
        ];

        foreach($roles as $role) {
            City::create([
                'country_id'    => $role['country_id'],
                'name'          => $role['title'],
                'slug'          => Str::slug($role['title']),
                'status'        => $role['status']
            ]);
        }
    }
}
