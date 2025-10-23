<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Jewelry',
            "Men's Clothing",
            "Women's Clothing",
            'Home & Kitchen',
            'Sports & Outdoors',
            'Beauty & Personal Care',
            'Toys & Games',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }

        $this->command->info('✅ Categories seeded successfully!');
    }
}
