<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Sidebar Layout with Dynamic Content</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        rel="stylesheet" />
</head>

<body class="m-0 p-0">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-gray-400 w-48 flex flex-col items-center py-4 space-y-6 relative">
            <div class="flex space-x-2">
                <img class="w-6 h-6" src="https://storage.googleapis.com/a1aa/image/255218a3-ffde-424c-f1d3-6986b8cf7111.jpg" />
                <img class="w-6 h-6" src="https://storage.googleapis.com/a1aa/image/978fba74-ad56-4512-6d24-6e636a7605be.jpg" />
            </div>

            <button aria-label="Toggle menu" class="border border-black rounded-full p-2 hover:bg-gray-300">
                <i class="fas fa-bars text-black text-xl"></i>
            </button>

            <nav class="flex flex-col space-y-3 w-full px-4">
                <button
                    onclick="loadPage(&#39;{{ route('dashboard') }}&#39;)"
                    class="flex items-center space-x-2 bg-gray-500 rounded-full py-2 px-4 text-black text-xs w-full text-left">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </button>

                <button
                    onclick="loadPage('{{ route('stock-in') }}')"
                    class="flex items-center space-x-2 bg-gray-600 rounded-full py-2 px-4 text-white text-xs w-full text-left">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Stock In</span>
                </button>

                <button
                    onclick="loadPage('{{ route('sales') }}')"
                    class="flex items-center space-x-2 bg-gray-500 rounded-full py-2 px-4 text-black text-xs w-full text-left">
                    <i class="fas fa-percent"></i>
                    <span>Sales</span>
                </button>

                <button
                    onclick="loadPage('{{ route('inventory') }}')"
                    class="flex items-center space-x-2 bg-gray-500 rounded-full py-2 px-4 text-black text-xs w-full text-left">
                    <i class="fas fa-pen-square"></i>
                    <span>Inventory</span>
                </button>
            </nav>
        </aside>

        <!-- Main Content -->
        <main id="main-content" class="flex-1 bg-gray-200 relative">
            <!-- Initial default content -->
            <div class="p-6 text-center text-gray-600">Please select a menu option from the sidebar.</div>
        </main>
    </div>

    <script>
        function loadPage(url) {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('main-content').innerHTML = html;
                })
                .catch(error => {
                    document.getElementById('main-content').innerHTML = '<p class="text-red-600 p-4">Error loading content.</p>';
                    console.error('Error loading page:', error);
                });
        }
    </script>
</body>

</html>