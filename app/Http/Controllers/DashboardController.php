<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(Request $request)
    {

        $start = $request->start ??
            Carbon::now()->subMonth()->startOfDay();

        $end = $request->end ??
            Carbon::now()->endOfDay();

        $totalProducts = Product::count();

        $latestProduct =
            Product::latest()->first();

        $topCategory = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->first();

        $categoryData = Product::join(
            'categories',
            'products.category_id',
            '=',
            'categories.id'
        )
            ->select(
                'categories.name',
                DB::raw('count(*) as total')
            )
            ->groupBy('categories.name')
            ->get();

        // $dateData = Product::select(
        //     DB::raw('DATE(last_synced_at) as date'),
        //     DB::raw('count(*) as total')
        // )
        //     ->whereNotNull('last_synced_at')
        //     ->whereBetween(
        //         'last_synced_at',
        //         [$start, $end]
        //     )->groupBy('date')->orderBy('date')->get();

        // STOCK DISTRIBUTION
        $stockDistribution = [
            'Out of Stock' =>
            Product::where('stock', 0)->count(),
            'Low Stock' =>
            Product::whereBetween('stock', [1, 20])->count(),
            'Medium Stock' =>
            Product::whereBetween('stock', [21, 50])->count(),
            'High Stock' =>
            Product::where('stock', '>', 50)->count()
        ];


        // AVERAGE RATING PER CATEGORY
        $ratingData = Product::join(
            'categories',
            'products.category_id',
            '=',
            'categories.id'
        )
            ->select(
                'categories.name',
                DB::raw('AVG(rating) as avg_rating')
            )->whereNotNull('rating')->groupBy('categories.name')->get();


        // PRICE DISTRIBUTION
        $priceDistribution = [
            '0-50' =>
            Product::whereBetween('price', [0, 50])->count(),
            '50-100' =>
            Product::whereBetween('price', [51, 100])->count(),
            '100-500' =>
            Product::whereBetween('price', [101, 500])->count(),
            '500+' =>
            Product::where('price', '>', 500)->count()
        ];

        return view('dashboard', compact(

            'totalProducts',
            'topCategory',
            'latestProduct',

            'categoryData',
            'stockDistribution',

            'ratingData',
            'priceDistribution',

            'start',
            'end'

        ));
    }
}
