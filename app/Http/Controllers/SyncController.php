<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

class SyncController extends Controller
{

    public function sync(ProductService $service)
    {

        $service->sync();

        return redirect()->back()
            ->with('success', 'Sync berhasil');
    }
}
