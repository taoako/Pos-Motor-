<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Modern Dashboard with Animated Buttons</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        /* Animation for the buttons */
        .btn-hover {
            transition: all 0.3s ease-in-out;
        }

        .btn-hover:hover {
            transform: scale(1.1);
            background-color: #4CAF50; /* Green on hover */
        }

        .btn-focus {
            outline: none;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<body class="bg-gray-900 text-white">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-gray-800 w-64 flex flex-col items-center py-6 space-y-6 relative">
            <div class="flex space-x-2">
                <img alt="Logo" class="w-8 h-8" src="https://storage.googleapis.com/a1aa/image/255218a3-ffde-424c-f1d3-6986b8cf7111.jpg" />
                <img alt="Logo" class="w-8 h-8" src="https://storage.googleapis.com/a1aa/image/978fba74-ad56-4512-6d24-6e636a7605be.jpg" />
            </div>

            <!-- Sidebar toggle button -->
            <button aria-label="Toggle menu" class="border-2 border-gray-700 rounded-full p-2 hover:bg-gray-700 btn-hover">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Sidebar navigation -->
            <nav class="flex flex-col items-center space-y-4 w-full px-6">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 text-xs w-full text-center hover:bg-gray-600 transition btn-hover">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('stock-in') }}" class="flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 text-xs w-full text-center hover:bg-gray-600 transition btn-hover">
                    <i class="fas fa-cart-plus"></i> <span>Stock In</span>
                </a>
                <a href="{{ route('sales') }}" class="flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 text-xs w-full text-center hover:bg-gray-600 transition btn-hover">
                    <i class="fas fa-percent"></i> <span>Sales</span>
                </a>
                <a href="{{ route('inventory') }}" class="flex items-center space-x-3 bg-gray-700 rounded-full py-2 px-5 text-xs w-full text-center hover:bg-gray-600 transition btn-hover">
                    <i class="fas fa-box"></i> <span>Inventory</span>
                </a>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 bg-gray-900">
            <!-- Top bar -->
            <header class="bg-gray-800 flex items-center justify-between px-6 py-4">
                <form aria-label="Site search" class="flex items-center bg-gray-700 rounded-full px-4 py-2 w-36 max-w-full" role="search" method="GET" action="{{ route('search') }}">
                    <input class="outline-none text-xs text-white bg-transparent w-full" placeholder="Search" type="search" name="query" value="{{ request('query') }}" />
                    <button aria-label="Search button" class="pl-2 btn-hover">
                        <i class="fas fa-search text-white text-xs"></i>
                    </button>
                </form>

                <!-- User Profile Section -->
                <div class="flex items-center space-x-4">
                    <span class="text-white text-xs">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <button aria-label="User profile" class="bg-orange-600 rounded-full p-2 flex items-center justify-center btn-hover">
                        <i class="fas fa-user text-white text-sm"></i>
                    </button>

                    <!-- Dropdown menu -->
                    <div class="relative">
                        <button id="dropdownButton" aria-haspopup="true" aria-expanded="false" aria-label="Open profile menu" class="text-white text-xl focus:outline-none">
                            <i class="fas fa-cogs"></i>
                        </button>
                        <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg z-50" role="menu" aria-orientation="vertical" aria-labelledby="dropdownButton">
                            <a href="{{ route('profile.settings') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700" role="menuitem">Profile Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700" role="menuitem">Log Out</button>
                            </form>
                            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700" role="menuitem">Register Another User</a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content goes here -->
            <div class="p-6">
                <h1 class="text-2xl font-bold text-white">Welcome to Your Dashboard</h1>
                <!-- Add additional content or widgets here -->
            </div>
        </main>
    </div>

    <script>
        // Dropdown Menu toggle
        const dropdownButton = document.getElementById("dropdownButton");
        const dropdownMenu = document.getElementById("dropdownMenu");

        dropdownButton.addEventListener("click", () => {
            const isExpanded = dropdownButton.getAttribute("aria-expanded") === "true" || false;
            dropdownButton.setAttribute("aria-expanded", !isExpanded);
            dropdownMenu.classList.toggle("hidden");
        });

        // Close dropdown if clicked outside
        window.addEventListener("click", (e) => {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add("hidden");
                dropdownButton.setAttribute("aria-expanded", false);
            }
        });
    </script>
</body>

</html>
