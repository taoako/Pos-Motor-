<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Modern Dashboard</title>

    <!-- Tailwind CSS & Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    <!-- Bootstrap (for modals) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Your custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
</head>

<body class="bg-gray-900 text-white fade-in">
    {{-- Session Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show position-fixed top-3 start-50 translate-middle-x z-50"
            role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="bg-gray-800 w-64 flex flex-col items-center py-6 space-y-6 transition-all duration-300">
            <div class="flex space-x-2">
                <img class="w-8 h-8 rounded-full"
                    src="https://storage.googleapis.com/a1aa/image/255218a3-ffde-424c-f1d3-6986b8cf7111.jpg"
                    alt="Avatar 1" />
                <img class="w-8 h-8 rounded-full"
                    src="https://storage.googleapis.com/a1aa/image/978fba74-ad56-4512-6d24-6e636a7605be.jpg"
                    alt="Avatar 2" />
            </div>

            <nav class="flex flex-col items-center space-y-4 w-full px-6">
                <button data-url="{{ route('dashboard.content') }}"
                    class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 transition-colors">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </button>

                <button data-url="{{ route('stock-in.content') }}"
                    class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 transition-colors">
                    <i class="fas fa-cart-plus"></i>
                    <span>Stock In</span>
                </button>

                <button data-url="{{ route('sales.content') }}"
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
                <button data-url="{{ route('employees.index') }}"
                    class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 transition-colors">
                    <i class="fas fa-users"></i>
                    <span>Manage Employees</span>
                </button>
                <button onclick="window.open('{{ url('/pos') }}', '_blank')"
                    class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 transition-colors">
                    <i class="fas fa-cash-register"></i>
                    <span>POS</span>
                </button>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 bg-gray-900 fade-in">
            <header class="bg-gray-800 flex items-center justify-between px-6 py-4">
                <!-- Sidebar toggle -->
                <button id="sidebarToggle"
                    class="border-2 border-gray-700 rounded-full p-2 hover:bg-gray-700 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Search form -->
                <form method="GET" action="{{ route('search') }}"
                    class="flex items-center bg-gray-700 rounded-full px-4 py-2 w-36">
                    <input type="search" name="query" class="outline-none text-xs text-white bg-transparent w-full"
                        placeholder="Search" value="{{ request('query') }}" />
                    <button class="pl-2">
                        <i class="fas fa-search text-white text-xs"></i>
                    </button>
                </form>

                <!-- User + settings dropdown -->
                <div class="flex items-center space-x-4 relative">
                    <span class="text-white text-xs">
                        {{ Auth::user()->name ?? 'Admin' }}
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
                        <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700"
                            data-bs-toggle="modal" data-bs-target="#registerModal">
                            Register Another User
                        </a>
                    </div>
                </div>
            </header>

            <!-- Dynamic content area -->
            <div id="main-content" class="p-6 space-y-4">
                <h1 class="text-2xl font-bold">Welcome to Your Dashboard</h1>
                <!-- Content appears here -->
            </div>
        </main>
    </div>

    <!-- Bootstrap JS & dynamic loading script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add this inside your <script> tag in dashboard.blade.php
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar toggle
            document.getElementById('sidebarToggle').addEventListener('click', () => {
                document.getElementById('sidebar').classList.toggle('-translate-x-full');
            });

            // Settings dropdown toggle
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');

            dropdownButton.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });

            dropdownMenu.addEventListener('click', (e) => {
                e.stopPropagation();
            });

            document.addEventListener('click', (e) => {
                if (!dropdownMenu.classList.contains('hidden')) {
                    if (!dropdownMenu.contains(e.target) && !dropdownButton.contains(e.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                }
            });

            // AJAX content loading: swap only inner #main-content
            document.querySelectorAll('button[data-url]').forEach(btn => {
                btn.addEventListener('click', async () => {
                    try {
                        const res = await fetch(btn.dataset.url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        if (!res.ok) throw new Error('Network error');

                        const text = await res.text();
                        const doc = new DOMParser().parseFromString(text, 'text/html');
                        const frag = doc.getElementById('main-content');
                        const target = document.getElementById('main-content');

                        if (frag) {
                            target.innerHTML = frag.innerHTML;
                        } else {
                            // Fallback: inject entire response
                            target.innerHTML = text;
                        }
                    } catch (err) {
                        console.error(err);
                        document.getElementById('main-content').innerHTML =
                            `<div class="text-red-500">Failed to load content.</div>`;
                    }
                });
            });
        });
    </script>
    @include('auth.register')
    @include('auth.profile')
</body>

</html>