<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Models\SyncLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ProductService
{

    public function sync()
    {

        DB::beginTransaction();

        try {

            $response = Http::get('https://dummyjson.com/products?limit=100');

            $products = $response->json()['products'];

            $total = 0;

            foreach ($products as $item) {

                // CATEGORY
                $category = Category::firstOrCreate([
                    'name' => $item['category']
                ]);

                // PRODUCT
                Product::updateOrCreate(

                    ['api_id' => $item['id']],

                    [
                        'title' => $item['title'],
                        'price' => $item['price'],
                        'category_id' => $category->id,
                        'brand' => $item['brand'] ?? null,
                        'rating' => $item['rating'] ?? null,
                        'stock' => $item['stock'] ?? null,
                        'discount' => $item['discountPercentage'] ?? null,
                        'last_synced_at' => now()
                    ]

                );

                $total++;
            }

            SyncLog::create([

                'last_sync' => now(),
                'total_data' => $total,
                'status' => 'success'

            ]);

            DB::commit();

            return true;
        } catch (\Exception $e) {

            DB::rollback();

            SyncLog::create([

                'last_sync' => now(),
                'total_data' => 0,
                'status' => 'failed'

            ]);

            return false;
        }
    }
}
