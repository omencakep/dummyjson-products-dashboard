@extends('layouts.app')

@section('title', 'Product Management')

@section('content')
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-3 shadow-sm"
            role="alert">
            <i class="fa-solid fa-circle-check text-xl"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div
        class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">

        <div class="flex items-center gap-3">
            <div class="relative w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <i class="fa-solid fa-filter"></i>
                </div>
                <select id="categoryFilter"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 transition-colors">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <div class="text-sm text-gray-500 flex items-center gap-2 border-r border-gray-200 pr-4">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Last Sync:
                    <strong>{{ optional(App\Models\SyncLog::latest()->first())->last_sync ?? 'Never' }}</strong></span>
            </div>

            <a href="/sync-test"
                class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                <i class="fa-solid fa-rotate text-green-600"></i> Sync Data
            </a>

            <a href="/products/create"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                <i class="fa-solid fa-plus"></i> Add Product
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5">
            <table id="productTable" class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Title</th>
                        <th class="py-3 px-4">Price</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Stock</th>
                        <th class="py-3 px-4">Source</th>
                        <th class="py-3 px-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 font-medium text-gray-900" data-sort="{{ $product->id }}">
                                #{{ $product->id }}
                            </td>
                            <td class="py-3 px-4 font-semibold text-gray-800">
                                {{ $product->title }}
                            </td>
                            <td class="py-3 px-4">
                                {{ $product->price }}
                            </td>
                            <td class="py-3 px-4">
                                @if ($product->category)
                                    <span
                                        class="bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold px-2.5 py-1 rounded-md">
                                        {{ $product->category->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 italic">No Category</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if ($product->stock > 0)
                                    <span class="text-green-600 font-medium">{{ $product->stock }}</span>
                                @else
                                    <span class="text-red-500 font-medium">Out of Stock</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if ($product->api_id == 0)
                                    <span
                                        class="bg-gray-100 text-gray-700 border border-gray-200 text-xs font-medium px-2.5 py-1 rounded-md flex items-center gap-1 w-fit">
                                        <i class="fa-solid fa-keyboard text-gray-400"></i> Manual
                                    </span>
                                @else
                                    <span
                                        class="bg-purple-50 text-purple-700 border border-purple-200 text-xs font-medium px-2.5 py-1 rounded-md flex items-center gap-1 w-fit">
                                        <i class="fa-solid fa-cloud-arrow-down text-purple-400"></i> API
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 flex justify-center gap-2">
                                <a href="/products/{{ $product->id }}/edit"
                                    class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors"
                                    title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form action="/products/{{ $product->id }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors"
                                        onclick="return confirm('Are you sure you want to delete this product?')"
                                        title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.25rem 0.75rem;
            outline: none;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 1px #3b82f6;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #f3f4f6 !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 0.5rem;
        }

        table.dataTable.no-footer {
            border-bottom: 1px solid #f3f4f6;
        }
    </style>

    <script>
        $(document).ready(function() {
            var table = $('#productTable').DataTable({
                order: [
                    [0, 'desc']
                ],

                // Mengatur ulang letak elemen DataTables agar lebih rapi
                dom: '<"flex justify-between items-center mb-4"lf>rt<"flex justify-between items-center mt-4"ip>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search products..."
                }
            });

            $('#categoryFilter').on('change', function() {
                table
                    .column(3)
                    .search(this.value)
                    .draw();
            });
        });
    </script>
@endsection
