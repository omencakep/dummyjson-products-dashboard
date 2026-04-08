@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Product</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Updating information for <span class="font-semibold text-gray-700">"{{ $product->title }}"</span>
                </p>
            </div>
            <span class="bg-gray-100 text-gray-600 border border-gray-200 text-sm font-medium px-3 py-1 rounded-lg">
                ID: #{{ $product->id }}
            </span>
        </div>

        @if ($errors->any())
            <div
                class="bg-red-50 border border-red-200 text-red-700 px-4 py-4 rounded-lg mb-6 shadow-sm flex items-start gap-3">
                <i class="fa-solid fa-triangle-exclamation text-xl mt-0.5"></i>
                <div>
                    <h4 class="font-bold mb-1">Please fix the following errors:</h4>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <form method="POST" action="/products/{{ $product->id }}" class="p-6 md:p-8">
                @csrf
                @method('PUT')

                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Basic Information</h3>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Title <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $product->title) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-colors"
                        required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category <span
                                class="text-red-500">*</span></label>
                        <select name="category_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-colors"
                            required>
                            <option value="" disabled>Select a category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                        <input type="text" name="brand" value="{{ old('brand', $product->brand) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-colors">
                    </div>
                </div>

                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Pricing & Inventory</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-8 p-2.5 transition-colors"
                                required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Discount</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="discount"
                                value="{{ old('discount', $product->discount) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-8 p-2.5 transition-colors">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">%</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-yellow-400">
                                <i class="fa-solid fa-star text-xs"></i>
                            </div>
                            <input type="number" step="0.01" min="0" max="5" name="rating"
                                value="{{ old('rating', $product->rating) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-8 p-2.5 transition-colors">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-5 border-t border-gray-100">
                    <a href="/products"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>

                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-amber-500 rounded-lg hover:bg-amber-600 focus:ring-4 focus:ring-amber-300 transition-colors flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Update Product
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
