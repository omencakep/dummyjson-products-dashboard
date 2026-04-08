<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;


Route::redirect('/', '/dashboard');

Route::post('/sync-products', [SyncController::class, 'sync'])
    ->name('sync.products');

Route::resource('products', ProductController::class);

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
);

Route::get('/sync-test', function () {
    $service = new \App\Services\ProductService();
    $service->sync();

    // Redirect ke halaman products dan kirim session 'success'
    return redirect('/products')->with('success', 'Products synced successfully from API!');
});
