<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RealProductsSeeder extends Seeder
{
    public function run()
    {
        Storage::makeDirectory('public/products');

//        $response = Http::get('https://fakestoreapi.com/products');
        $response = Http::get('https://dummyjson.com/products');
        if (!$response->ok()) {
            $this->command->error('❌ Failed to fetch products');
            return;
        }

        $products = $response->json();

        foreach ($products['products'] as $item) {
            try {

                $imageUrl = $item['images'][0];
                $imgData = Http::get($imageUrl)->body();
                $filename = 'product-' . Str::slug($item['title']) . '-' . Str::random(5) . '.jpg';
                Storage::put('public/products/' . $filename, $imgData);

                // إنشاء أو تحديث المنتج
                $product = Product::updateOrCreate(
                    ['slug' => Str::slug($item['title'])],
                    [
                        'name' => $item['title'],
                        'description' => $item['description'],
                        'price' => intval($item['price'] * 100),
                        'image' => 'products/' . $filename,
                        'stock' => rand(5, 100),
                        'sku' => strtoupper(Str::random(8)),
                    ]
                );

                // البحث عن الفئة أو إنشاؤها
                $categoryName = ucfirst($item['category']);
                $category = Category::firstOrCreate(
                    ['slug' => Str::slug($categoryName)],
                    ['name' => $categoryName]
                );

                // ربط المنتج بالفئة
                $product->categories()->syncWithoutDetaching([$category->id]);

            } catch (\Exception $e) {
                \Log::warning('❗ Error saving product: ' . $item['title'] . ' - ' . $e->getMessage());
            }
        }

        $this->command->info('✅ Real products imported with category relations!');
    }
}
