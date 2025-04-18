<html lang="en">




<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Sidebar Layout with Dropdown</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        rel="stylesheet" />
</head>

<body class="m-0 p-0">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside
            class="bg-gray-400 w-48 flex flex-col items-center py-4 space-y-6 relative">
            <div class="flex space-x-2">
                <img
                    alt="Orange gear icon 1"
                    class="w-6 h-6"
                    height="24"
                    src="https://storage.googleapis.com/a1aa/image/255218a3-ffde-424c-f1d3-6986b8cf7111.jpg"
                    width="24" />
                <img
                    alt="Orange gear icon 2"
                    class="w-6 h-6"
                    height="24"
                    src="https://storage.googleapis.com/a1aa/image/978fba74-ad56-4512-6d24-6e636a7605be.jpg"
                    width="24" />
            </div>
            <button
                aria-label="Toggle menu"
                class="border border-black rounded-full p-2 hover:bg-gray-300">
                <i class="fas fa-bars text-black text-xl"></i>
            </button>
            <nav class="flex flex-col space-y-3 w-full px-4">
                <a
                    href="{{ route('dashboard') }}"
                    class="flex items-center space-x-2 bg-gray-500 rounded-full py-2 px-4 text-black text-xs"> <i class="fas fa-th-large"></i> <span>Dashboard</span> </a>
                <a
                    href="{{ route('stock-in') }}"
                    class="flex items-center space-x-2 bg-gray-600 rounded-full py-2 px-4 text-white text-xs"> <i class="fas fa-shopping-cart"></i> <span>Stock In</span> </a>
                <a
                    href="{{ route('sales') }}"
                    class="flex items-center space-x-2 bg-gray-500 rounded-full py-2 px-4 text-black text-xs"> <i class="fas fa-percent"></i> <span>Sales</span> </a>
                <a
                    href="{{ route('inventory') }}"
                    class="flex items-center space-x-2 bg-gray-500 rounded-full py-2 px-4 text-black text-xs"> <i class="fas fa-pen-square"></i> <span>Inventory</span> </a>
            </nav>
        </aside>
        <!-- Main content -->
        <main class="flex-1 bg-gray-200 relative">
            <!-- Top bar -->
            <header
                class="bg-gray-600 flex items-center justify-end space-x-4 px-4 py-2 relative">
                <form
                    aria-label="Site search"
                    class="flex items-center bg-white rounded-full px-2 py-1 w-36 max-w-full"
                    role="search"
                    method="GET"
                    action="{{ route('search') }}">
                    <input
                        class="outline-none text-xs text-black bg-transparent w-full"
                        placeholder="Search"
                        type="search"
                        name="query"
                        value="{{ request('query') }}" />
                    <button aria-label="Search button" class="pl-1" type="submit">
                        <i class="fas fa-search text-black text-xs"></i>
                    </button>
                </form>
                <span class="text-white text-xs">{{ Auth::user()->name ?? 'Admin' }}</span>
                <button
                    aria-label="User profile"
                    class="bg-orange-500 rounded-full p-2 flex items-center justify-center">
                    <i class="fas fa-user text-black text-sm"></i>
                </button>
                <!-- Dropdown container -->
                <div class="relative">
                    <button
                        id="dropdownButton"
                        aria-haspopup="true"
                        aria-expanded="false"
                        aria-label="Open profile menu"
                        class="text-black text-xl focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div
                        id="dropdownMenu"
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50"
                        role="menu"
                        aria-orientation="vertical"
                        aria-labelledby="dropdownButton">
                        <a
                            href="{{ route('profile.settings') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            role="menuitem">Profile Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                role="menuitem">
                                Log Out
                            </button>
                        </form>
                        <a
                            href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            role="menuitem"
                            data-bs-toggle="modal"
                            data-bs-target="#registerModal">
                            Register Another User
                        </a>
                    </div>
                </div>
            </header>
        </main>
    </div>

    <script>
        const dropdownButton = document.getElementById("dropdownButton");
        const dropdownMenu = document.getElementById("dropdownMenu");

        dropdownButton.addEventListener("click", () => {
            const isExpanded =
                dropdownButton.getAttribute("aria-expanded") === "true" || false;
            dropdownButton.setAttribute("aria-expanded", !isExpanded);
            dropdownMenu.classList.toggle("hidden");
        });

        // Close dropdown if clicked outside
        window.addEventListener("click", (e) => {
            if (
                !dropdownButton.contains(e.target) &&
                !dropdownMenu.contains(e.target)
            ) {
                dropdownMenu.classList.add("hidden");
                dropdownButton.setAttribute("aria-expanded", false);
            }
        });
    </script>
</body>


</html>

@include('auth.register') <!-- or the correct path to your modal -->