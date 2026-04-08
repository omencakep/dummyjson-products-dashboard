<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('category')
            ->orderBy('updated_at', 'desc')
            ->get();

        $categories = Category::all();

        return view('products.index', compact(
            'products',
            'categories'
        ));
    }

    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required'
        ]);

        Product::create([
            'api_id' => null,
            'title' => $request->title,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'brand' => $request->brand,
            'rating' => $request->rating,
            'stock' => $request->stock,
            'discount' => $request->discount,
            'last_synced_at' => now()
        ]);

        return redirect('/products')
            ->with('success', 'Product created');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $categories = Category::all();

        return view(
            'products.edit',
            compact('product', 'categories')
        );
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required'
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'title' => $request->title,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'brand' => $request->brand,
            'rating' => $request->rating,
            'stock' => $request->stock,
            'discount' => $request->discount
        ]);

        return redirect('/products')->with('success', 'Product updated');
    }

    public function destroy($id)
    {

        Product::findOrFail($id)->delete();

        return redirect('/products')
            ->with('success', 'Deleted');
    }
}
