<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Modern Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        .slide-in {
            animation: slideInLeft 0.5s ease-out;
        }

        .btn-hover {
            transition: all 0.3s ease-in-out;
        }

        .btn-hover:hover {
            transform: scale(1.1);
            background-color: #4CAF50;
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.6);
        }

        .nav-link {
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .nav-link:hover {
            transform: translateX(5px) scale(1.05);
        }
    </style>
</head>

<body class="bg-gray-900 text-white fade-in">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-gray-800 w-64 flex flex-col items-center py-6 space-y-6 relative slide-in">
            <div class="flex space-x-2">
                <img class="w-8 h-8" src="https://storage.googleapis.com/a1aa/image/255218a3-ffde-424c-f1d3-6986b8cf7111.jpg" />
                <img class="w-8 h-8" src="https://storage.googleapis.com/a1aa/image/978fba74-ad56-4512-6d24-6e636a7605be.jpg" />
            </div>
            <button class="border-2 border-gray-700 rounded-full p-2 hover:bg-gray-700 btn-hover">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <nav class="flex flex-col items-center space-y-4 w-full px-6">
                <button data-url="{{ route('dashboard.content') }}" class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 btn-hover">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </button>
                <button data-url="{{ route('stock-in.content') }}" class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 btn-hover">
                    <i class="fas fa-cart-plus"></i> <span>Stock In</span>
                </button>
                <button data-url="{{ route('sales.content') }}" class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 btn-hover">
                    <i class="fas fa-percent"></i> <span>Sales</span>
                </button>
                <button data-url="{{ route('inventory.content') }}" class="nav-link flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 w-full text-center hover:bg-gray-600 btn-hover">
                    <i class="fas fa-box"></i> <span>Inventory</span>
                </button>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 bg-gray-900 fade-in">
            <header class="bg-gray-800 flex items-center justify-between px-6 py-4">
                <form method="GET" action="{{ route('search') }}" class="flex items-center bg-gray-700 rounded-full px-4 py-2 w-36">
                    <input type="search" name="query" class="outline-none text-xs text-white bg-transparent w-full" placeholder="Search" value="{{ request('query') }}" />
                    <button class="pl-2 btn-hover">
                        <i class="fas fa-search text-white text-xs"></i>
                    </button>
                </form>
                <div class="flex items-center space-x-4">
                    <span class="text-white text-xs">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <button class="bg-orange-600 rounded-full p-2 btn-hover">
                        <i class="fas fa-user text-white text-sm"></i>
                    </button>
                    <div class="relative">
                        <button id="dropdownButton" class="text-white text-xl">
                            <i class="fas fa-cogs"></i>
                        </button>
                        <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg z-50">
                            <a href="{{ route('profile.settings') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Profile Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Log Out</button>
                            </form>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700" data-bs-toggle="modal" data-bs-target="#registerModal">
                                Register Another User
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dynamic content area -->
            <div id="main-content" class="p-6 space-y-4">
                <h1 class="text-2xl font-bold">Welcome to Your Dashboard</h1>
                <!-- Content from other routes will be loaded here -->
            </div>
        </main>
    </div>

    <script>
        const navButtons = document.querySelectorAll('nav button[data-url]');
        const contentArea = document.getElementById('main-content');

        navButtons.forEach(button => {
            button.addEventListener('click', async () => {
                const url = button.getAttribute('data-url');
                try {
                    const response = await fetch(url);
                    const html = await response.text();
                    contentArea.innerHTML = html;
                } catch (error) {
                    contentArea.innerHTML = `<div class="text-red-500">Failed to load content.</div>`;
                    console.error(error);
                }
            });
        });

        const dropdownButton = document.getElementById("dropdownButton");
        const dropdownMenu = document.getElementById("dropdownMenu");

        dropdownButton.addEventListener("click", () => {
            dropdownMenu.classList.toggle("hidden");
        });

        window.addEventListener("click", (e) => {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add("hidden");
            }
        });
    </script>


    @include('auth.register')
</body>

</html>