<div class="p-6 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300">
    <h2 class="text-3xl font-extrabold text-white mb-6 flex items-center gap-2 animate__animated animate__fadeIn">
        <span>🛠️</span><span>Stock In - Car & Motor Parts</span>
    </h2>
    
    <a href="{{ route('stock-in-details.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl shadow-md mb-6 inline-block transform hover:scale-110 transition-transform duration-300 hover:shadow-lg">
        + Add New Stock
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-800 text-white rounded-xl shadow-md transition-all duration-300">
            <thead class="bg-gray-700 text-gray-200">
                <tr>
                    <th class="py-3 px-6 text-left">Part Name</th>
                    <th class="py-3 px-6 text-left">Quantity</th>
                    <th class="py-3 px-6 text-left">Supplier</th>
                    <th class="py-3 px-6 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-700 transition-colors duration-300">
                    <td class="py-3 px-6">Motorcycle Brake Pads</td>
                    <td class="py-3 px-6">100</td>
                    <td class="py-3 px-6">SpeedTech</td>
                    <td class="py-3 px-6">2025-04-19</td>
                </tr>
                <!-- Add more rows here dynamically -->
                <tr class="hover:bg-gray-700 transition-colors duration-300">
                    <td class="py-3 px-6">Car Alternator</td>
                    <td class="py-3 px-6">50</td>
                    <td class="py-3 px-6">AutoGears</td>
                    <td class="py-3 px-6">2025-04-17</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Tailwind CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
<!-- Animate.css CDN for animation -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
