<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [
            'Electronics',
            'Apparel',
            'Home and Kitchen',
            'Beauty and Personal Care',
            'Books',
            'Toys and Games',
            'Sports and Outdoors',
            'Health and Wellness',
            'Automotive',
            'Office Supplies',
        ];
        foreach ($category as $category)
        {
            Category::create([
                'name' => $category,
            ]);
        }
    }
}
