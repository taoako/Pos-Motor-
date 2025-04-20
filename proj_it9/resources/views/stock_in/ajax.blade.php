<div class="p-6">
    <h2 class="text-xl font-bold text-gray-700 mb-6">📦 Stock In</h2>

    <!-- Stock In Form -->
    <form method="POST" action="{{ route('stock-in.store') }}" class="bg-white rounded-lg shadow p-4 space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
            </div>
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
            </div>
            <div>
                <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                <select name="supplier_id" id="supplier_id" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    <option value="">Select Supplier</option>
                    <!-- Dynamic options later -->
                </select>
            </div>
            <div>
                <label for="stock_date" class="block text-sm font-medium text-gray-700">Stock Date</label>
                <input type="date" name="stock_date" id="stock_date" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>
        </div>
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm">
            ➕ Add Stock
        </button>
    </form>

    <!-- Recently Added Stock Table -->
    <div class="mt-8 bg-white shadow rounded-lg overflow-x-auto">
        <h3 class="text-md font-semibold text-gray-800 px-4 pt-4">📋 Recent Stock-Ins</h3>
        <table class="min-w-full text-sm text-left table-auto">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Supplier</th>
                    <th class="px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                <!-- Replace this with a loop of stock-ins -->
                <tr class="border-t">
                    <td class="px-4 py-2">Brake Pads</td>
                    <td class="px-4 py-2">20</td>
                    <td class="px-4 py-2">AutoZone</td>
                    <td class="px-4 py-2">2025-04-17</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2">Oil Filter</td>
                    <td class="px-4 py-2">15</td>
                    <td class="px-4 py-2">PartsPro</td>
                    <td class="px-4 py-2">2025-04-16</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>