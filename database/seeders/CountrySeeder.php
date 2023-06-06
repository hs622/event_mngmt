<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name'          => 'Pakistan',
                'status'        => 1
            ],
            [
                'name'          => 'India',
                'status'        => 1
            ],
            [
                'name'          => 'Singapore',
                'status'        => 1
            ],
        ];

        foreach($roles as $role) {
            Country::create([
                'name' => $role['name'],
                'slug' => Str::slug($role['name']),
                'status' => $role['status']
            ]);
        }
    }
}
