@extends('layouts.app')

@section('title', 'Dashboard Analytics')

@section('content')
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-8 flex justify-between items-center">
        <h3 class="font-medium text-gray-700">Filter Data</h3>
        <form class="flex items-center gap-3" method="GET">
            <div class="flex items-center gap-2">
                <label class="text-sm text-gray-500">Start</label>
                <input type="date" name="start" value="{{ $start ?? '' }}"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">
            </div>
            <div class="flex items-center gap-2">
                <label class="text-sm text-gray-500">End</label>
                <input type="date" name="end" value="{{ $end ?? '' }}"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">
            </div>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                <i class="fa-solid fa-filter mr-1"></i> Apply Filter
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Products</p>
                <h2 class="text-3xl font-bold text-gray-800">{{ $totalProducts ?? 0 }}</h2>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xl">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Top Category</p>
                <h2 class="text-xl font-bold text-gray-800">{{ $topCategory->name ?? 'Belum ada' }}</h2>
            </div>
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-xl">
                <i class="fa-solid fa-star"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Latest Product</p>
                <h2 class="text-lg font-bold text-gray-800 truncate max-w-37.5">
                    {{ $latestProduct->title ?? 'Belum ada' }}</h2>
            </div>
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-4">
                <i class="fa-solid fa-chart-pie text-blue-500"></i>
                <h3 class="text-lg font-semibold text-gray-700">Products by Category</h3>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="pieChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-4">
                <i class="fa-solid fa-boxes-packing text-orange-500"></i>
                <h3 class="text-lg font-semibold text-gray-700">Stock Distribution</h3>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="stockChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-4">
                <i class="fa-solid fa-star-half-stroke text-indigo-500"></i>
                <h3 class="text-lg font-semibold text-gray-700">Avg Rating per Category</h3>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="ratingChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-4">
                <i class="fa-solid fa-tags text-green-500"></i>
                <h3 class="text-lg font-semibold text-gray-700">Price Distribution</h3>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="priceChart"></canvas>
            </div>
        </div>

    </div>

    <script>
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [4, 4],
                        color: '#f3f4f6'
                    },
                    border: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                }
            }
        };

        const doughnutOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            },
            cutout: '65%',
            borderWidth: 0
        };

        // 1. CHART PIE / CATEGORY
        const categoryLabels = {!! json_encode($categoryData->pluck('name') ?? []) !!};
        const categoryTotals = {!! json_encode($categoryData->pluck('total') ?? []) !!};
        new Chart(document.getElementById('pieChart'), {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryTotals,
                    backgroundColor: ['#3B82F6', '#10B981', '#8B5CF6', '#F59E0B', '#EF4444'],
                    hoverOffset: 4
                }]
            },
            options: doughnutOptions
        });

        // 2. STOCK CHART
        const stockLabels = {!! json_encode(array_keys($stockDistribution)) !!};
        const stockData = {!! json_encode(array_values($stockDistribution)) !!};
        new Chart(document.getElementById('stockChart'), {
            type: 'doughnut',
            data: {
                labels: stockLabels,
                datasets: [{
                    data: stockData,
                    backgroundColor: ['#EF4444', '#F59E0B', '#3B82F6', '#10B981'],
                    hoverOffset: 4
                }]
            },
            options: doughnutOptions
        });

        // 3. RATING CHART
        const ratingLabels = {!! json_encode($ratingData->pluck('name')) !!};
        const ratingValues = {!! json_encode($ratingData->pluck('avg_rating')) !!};
        new Chart(document.getElementById('ratingChart'), {
            type: 'bar',
            data: {
                labels: ratingLabels,
                datasets: [{
                    label: 'Average Rating',
                    data: ratingValues,
                    backgroundColor: '#8B5CF6', // Indigo/Purple
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                ...chartOptions,
                scales: {
                    ...chartOptions.scales,
                    y: {
                        ...chartOptions.scales.y,
                        max: 5
                    }
                }
            }
        });

        // 4. PRICE CHART
        const priceLabels = {!! json_encode(array_keys($priceDistribution)) !!};
        const priceValues = {!! json_encode(array_values($priceDistribution)) !!};
        new Chart(document.getElementById('priceChart'), {
            type: 'bar',
            data: {
                labels: priceLabels,
                datasets: [{
                    label: 'Products',
                    data: priceValues,
                    backgroundColor: '#10B981', // Emerald/Green
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: chartOptions
        });
    </script>
@endsection
