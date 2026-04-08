<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raka's Store Admin Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <div class="flex min-h-screen">

        <aside class="w-64 bg-gray-900 text-white flex flex-col shadow-xl">
            <div class="p-6 border-b border-gray-800 flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center font-bold text-white">
                    R
                </div>
                <h1 class="text-xl font-bold tracking-wider">Raka's Store</h1>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="/dashboard"
                    class="flex items-center gap-3 p-3 rounded-lg bg-blue-600 text-white shadow-md transition-all">
                    <i class="fa-solid fa-chart-pie w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="/products"
                    class="flex items-center gap-3 p-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-all">
                    <i class="fa-solid fa-box w-5"></i>
                    <span class="font-medium">Products</span>
                </a>
            </nav>
        </aside>

        <main class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm border-b border-gray-200 px-8 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">@yield('title', 'Overview')</h2>
                <div class="flex items-center gap-4 text-gray-500">
                    <button class="hover:text-blue-600"><i class="fa-solid fa-bell"></i></button>
                    <button class="hover:text-blue-600"><i class="fa-solid fa-gear"></i></button>
                </div>
            </header>

            <div class="flex-1 p-8 overflow-auto">
                @yield('content')
            </div>
        </main>

    </div>
</body>

</html>
