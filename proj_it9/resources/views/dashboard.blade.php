<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Modern Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f5f6fa;
            color: #222;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .bg-gray-900,
        .bg-gray-800,
        .sidebar,
        #sidebar {
            background-color: #fff !important;
        }

        .text-white,
        .text-gray-100,
        .text-gray-200,
        .text-gray-300,
        .text-gray-400,
        .text-gray-500,
        .text-gray-600,
        .text-gray-700,
        .text-gray-800,
        .text-gray-900 {
            color: #222 !important;
        }

        .shadow,
        .shadow-md,
        .shadow-lg {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
        }

        .rounded,
        .rounded-md,
        .rounded-lg,
        .rounded-full {
            border-radius: 12px !important;
        }

        .nav-link,
        .btn,
        .form-control,
        .bg-gray-700,
        .bg-gray-600 {
            background-color: #f8f9fa !important;
            color: #222 !important;
            border: 1px solid #e0e0e0 !important;
        }

        .nav-link.active,
        .btn-primary,
        .bg-orange-600 {
            background-color: #1976d2 !important;
            color: #fff !important;
            border: none !important;
        }

        .nav-link:hover,
        .btn:hover,
        .bg-gray-700:hover,
        .bg-gray-600:hover {
            background-color: #e3eafc !important;
            color: #1976d2 !important;
        }

        .modal-content {
            background-color: #fff !important;
            color: #222 !important;
        }

        .form-control:focus {
            border-color: #1976d2 !important;
            box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.15) !important;
        }

        .bg-orange-600 {
            background-color: #ff9800 !important;
            color: #fff !important;
        }

        .bg-orange-600:hover {
            background-color: #ffa726 !important;
        }

        .text-indigo-600 {
            color: #1976d2 !important;
        }

        .bg-indigo-600 {
            background-color: #1976d2 !important;
            color: #fff !important;
        }

        .hover\:bg-gray-700:hover {
            background-color: #e3eafc !important;
            color: #1976d2 !important;
        }

        .hover\:bg-orange-500:hover {
            background-color: #ffb74d !important;
        }

        .border-gray-700,
        .border-gray-800 {
            border-color: #e0e0e0 !important;
        }

        .shadow-lg {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08) !important;
        }

        .fade-in {
            animation: fadeIn 1s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-900 fade-in">
    {{-- Session Alert --}}
    @if (session('success'))
        <div
            class="fixed top-3 left-1/2 transform -translate-x-1/2 bg-green-600 text-white px-4 py-2 rounded shadow z-50 flex items-center justify-between min-w-[300px] max-w-md">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">&times;</button>
        </div>
    @endif

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
        
            class="bg-gray-800 w-64 flex flex-col items-center py-6 space-y-6 transition-all duration-300 transform -translate-x-0">
            <div   class="flex flex-col items-center space-y-2 mb-4">
    <img src="{{ asset('images/image.png') }}" alt="Logo" class="w-16 h-16 rounded-full shadow-lg border-2 border-blue-500">
            </div>
            <nav class="flex flex-col items-center space-y-4 w-full px-6">
                <button data-url="{{ route('dashboard.content') }}"
                    class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 transition-colors active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </button>

                <button data-url="{{ route('stock-in.content') }}"
                    class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 transition-colors">
                    <i class="fas fa-cart-plus"></i>
                    <span>Stock In</span>
                </button>

                <button data-url="{{ route('sales.index') }}"
                    class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 transition-colors">
                    <i class="fas fa-percent"></i>
                    <span>Sales</span>
                </button>

                <button data-url="{{ route('inventory.content') }}"
                    class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 transition-colors">
                    <i class="fas fa-box"></i>
                    <span>Inventory</span>
                </button>

                <button data-url="{{ route('suppliers.content') }}"
                    class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 transition-colors">
                    <i class="fas fa-truck"></i>
                    <span>Suppliers</span>
                </button>
                <button data-url="{{ route('products.content') }}"
                    class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 transition-colors">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                </button>
                @if (Auth::user()->employee->position === 'Admin')
                    <button data-url="{{ route('employees.content') }}"
                        class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 transition-colors">
                        <i class="fas fa-users"></i>
                        <span>Manage Employees</span>
                    </button>
                @endif

                @if (Auth::user()->employee->position === 'Admin')
                    <button onclick="window.location.href='{{ route('pos.index') }}'"
                        class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 transition-colors">
                        <i class="fas fa-cash-register"></i>
                        <span>POS</span>
                    </button>
                @endif
            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 bg-white fade-in">
            <header class="bg-white flex items-center justify-between px-6 py-4 border-bottom">
                <button id="sidebarToggle"
                    class="border-2 border-gray-700 rounded-full p-2 hover:bg-gray-700 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <form method="GET" action="{{ route('search') }}"
                    class="flex items-center bg-gray-700 rounded-full px-4 py-2 w-36">
                    <input type="search" name="query" class="outline-none text-xs text-white bg-transparent w-full"
                        placeholder="Search" value="{{ request('query') }}" />
                    <button class="pl-2">
                        <i class="fas fa-search text-white text-xs"></i>
                    </button>
                </form>

                <div class="flex items-center space-x-4 relative">
                    <span class="text-white text-xs">,
                        {{ Auth::user()->employee->first_name . ' ' . Auth::user()->employee->last_name ?? 'Admin' }}
                    </span>
                    <button class="bg-orange-600 rounded-full p-2 hover:bg-orange-500 transition-colors">
                        <i class="fas fa-user text-white text-sm"></i>
                    </button>
                    <button id="dropdownButton"
                        class="text-white text-xl p-2 hover:bg-gray-700 rounded-full transition-colors">
                        <i class="fas fa-cogs"></i>
                    </button>
                    <div id="dropdownMenu"
                        class="hidden absolute right-0 top-full mt-2 w-48 bg-gray-800 rounded-md shadow-lg z-50">

                        <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700"
                            data-bs-toggle="modal" data-bs-target="#profileModal">
                            Profile Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">
                                Log Out
                            </button>
                        </form>

                        @if (Auth::user()->employee->position === 'Admin')

                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700"
                                data-bs-toggle="modal" data-bs-target="#registerModal">
                                Register Another User
                            </a>
                        @endif
                    </div>
                </div>
            </header>

            <div id="main-content" class="p-6 space-y-4">
                <h1 class="text-2xl font-bold text-gray-900">Welcome to Your Dashboard</h1>
            </div>
        </main>
    </div>
    <!-- load Chart.js once at page load -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // global chart initializer, to be called after AJAX load
        window.initializeSalesChart = function () {
            const selector = document.getElementById('chartType');
            const canvas = document.getElementById('salesChart');
            if (!selector || !canvas) return;

            // parse embedded JSON
            const daily = JSON.parse(selector.dataset.daily);
            const weekly = JSON.parse(selector.dataset.weekly);
            const monthly = JSON.parse(selector.dataset.monthly);

            const ctx = canvas.getContext('2d');
            let chart = window._salesChart;

            function draw(data, key) {
                if (chart) chart.destroy();
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(d => d[key]),
                        datasets: [{
                            label: 'Sales (₱)',
                            data: data.map(d => +d.total),
                            tension: 0.3,
                            fill: true,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: { ticks: { color: 'white' } },
                            y: { ticks: { color: 'white', callback: v => '₱' + v.toLocaleString() } }
                        },
                        plugins: {
                            legend: { labels: { color: 'white' } },
                            tooltip: { mode: 'index', intersect: false }
                        }
                    }
                });
                window._salesChart = chart;
            }

            // initial draw and change handler
            draw(daily, 'day');
            selector.onchange = () => {
                if (selector.value === 'daily') draw(daily, 'day');
                if (selector.value === 'weekly') draw(weekly, 'week');
                if (selector.value === 'monthly') draw(monthly, 'month');
            };
        };
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentController = null;
            const loadContent = async (url) => {
                const target = document.getElementById('main-content');

                if (currentController) currentController.abort();
                currentController = new AbortController();
                const signal = currentController.signal;

                try {
                    const res = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        signal: signal
                    });
                    if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                    const html = await res.text();
                    target.innerHTML = html;

                    initializePagination();
                    initializeSidebarButtons();

                    // ✅ Re-initialize the chart after ensuring the DOM is updated

                    if (typeof initializeSalesChart === 'function') {
                        initializeSalesChart();
                    }
                } catch (err) {
                    if (err.name !== 'AbortError') {
                        console.error(err);
                        target.innerHTML = `<div class="text-red-500">Error loading content: ${err.message}</div>`;

                    }
                }
            };


            const initializeSidebarButtons = () => {
                const sidebarButtons = document.querySelectorAll('button[data-url]');

                sidebarButtons.forEach(btn => {
                    // Remove existing listener if exists
                    btn.removeEventListener('click', btn._handler);

                    // Add a new handler
                    const handler = (e) => {
                        e.preventDefault();
                        const url = btn.dataset.url;
                        if (url) loadContent(url);
                    };

                    btn._handler = handler; // Custom property to track
                    btn.addEventListener('click', handler);
                });
            };

            const initializePagination = () => {
                const paginationLinks = document.querySelectorAll('#pagination-links a');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        const url = this.getAttribute('href');
                        if (url) loadContent(url);
                    });
                });
            };

            // Sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    document.getElementById('sidebar').classList.toggle('-translate-x-full');
                });
            }

            // Dropdown toggle
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');
            if (dropdownButton && dropdownMenu) {
                dropdownButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', (e) => {
                    if (!dropdownMenu.classList.contains('hidden') &&
                        !dropdownMenu.contains(e.target) &&
                        !dropdownButton.contains(e.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            }

            // Initial binding
            initializeSidebarButtons();
            initializePagination();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('salesChart').getContext('2d');
            let salesChart;

            const fetchData = (period) => {
                fetch(`/sales-data?period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        const labels = data.map(item => item.period);
                        const totals = data.map(item => item.total_sales);

                        if (salesChart) {
                            salesChart.destroy();
                        }

                        salesChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Total Sales',
                                    data: totals,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Period'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Sales Amount (₱)'
                                        },
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
            };

            const periodSelect = document.getElementById('period');
            periodSelect.addEventListener('change', function () {
                fetchData(this.value);
            });

            // Initial load
            fetchData(periodSelect.value);
        });
    </script>




    @include('auth.register')
    @include('auth.profile')
</body>

</html>