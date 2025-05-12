<div class="p-6 bg-gray-800 rounded-2xl shadow-lg">
    <h2 class="text-3xl font-bold text-white mb-6">📦 Inventory - Car & Motor Parts</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Stock Levels Section -->
        <div class="overflow-x-auto">
            <h3 class="text-2xl font-semibold text-white mb-4">Stock Levels</h3>
            <table class="min-w-full bg-gray-700 text-white rounded-xl">
                <thead>
                    <tr class="bg-gray-600">
                        <th class="py-2 px-4 text-left">Image</th>
                        <th class="py-2 px-4 text-left">Name</th>
                        <th class="py-2 px-4 text-left">Brand</th>
                        <th class="py-2 px-4 text-left">Stock</th>
                        <th class="py-2 px-4 text-left">Selling Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-600">
                            <td class="py-2 px-4">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="w-16 h-16 object-cover rounded">
                            </td>
                            <td class="py-2 px-4">{{ $product->product_name }}</td>
                            <td class="py-2 px-4">{{ $product->brand }}</td>
                            <td class="py-2 px-4">{{ $product->stock }}</td>
                            <td class="py-2 px-4">₱{{ number_format($product->selling_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="pagination-links" class="mt-4">
                {{ $products->withPath(route('inventory.content'))->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Stock-Out Management Section -->
        <div>
            <h3 class="text-2xl font-semibold text-white mb-4">Stock-Out Transactions</h3>
            <!-- Record Button -->
            <div class="flex justify-end mb-4">
              <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#stockOutModal">
                Record Stock Out
              </button>
            </div>
            <table class="min-w-full bg-gray-700 text-white rounded-xl">
                <thead>
                    <tr class="bg-gray-600">
                        <th class="py-2 px-4 text-left">Reason</th>
                        <th class="py-2 px-4 text-left">Quantity</th>
                        <th class="py-2 px-4 text-left">Date</th>
                        <th class="py-2 px-4 text-left">Product</th>
                        <th class="py-2 px-4 text-left">Customer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stockOutLogs as $log)
                        <tr class="hover:bg-gray-600">
                            <td class="py-2 px-4">{{ ucfirst($log->reason) }}</td>
                            <td class="py-2 px-4">{{ $log->quantity }}</td>
                            <td class="py-2 px-4">{{ $log->logged_at->format('Y-m-d') }}</td>
                            <td class="py-2 px-4">{{ $log->product->product_name }}</td>
                            <td class="py-2 px-4">
                                @if ($log->reason === 'returned' && $log->sale)
                                    {{ $log->sale->transactiondetail->transaction->customer->first_name }} {{ $log->sale->transactiondetail->transaction->customer->last_name }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $stockOutLogs->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

<!-- Stock-Out Modal -->
<div class="modal fade" id="stockOutModal" tabindex="-1" aria-labelledby="stockOutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="stockOutForm" method="POST" action="{{ route('inventory.stockOut') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="stockOutModalLabel">Stock Out</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Reason -->
          <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <select name="reason" id="reason" class="form-select" required>
              <option value="damaged">Damaged</option>
              <option value="returned">Returned</option>
            </select>
          </div>

          <!-- Search (for both damaged-products and returned-sales) -->
          <div class="mb-3">
            <label id="searchLabel" for="searchInput" class="form-label">Search</label>
            <input type="text" id="searchInput" class="form-control" placeholder="Type to search..." autocomplete="off">
            <select name="" id="resultSelect" class="form-select mt-2" disabled>
              <option value="" disabled selected>Select an item</option>
            </select>
          </div>

          <!-- Quantity -->
          <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const reason     = document.getElementById('reason');
  const searchIn   = document.getElementById('searchInput');
  const searchLb   = document.getElementById('searchLabel');
  const resultSel  = document.getElementById('resultSelect');
  let mode = reason.value;

  function configure() {
    mode = reason.value;
    if (mode === 'damaged') {
      searchLb.textContent = 'Search In-Stock Products';
      resultSel.name       = 'product_id';
    } else {
      searchLb.textContent = 'Search Sold Products';
      resultSel.name       = 'sale_id';
    }
    resultSel.disabled = false;
    resultSel.required = true;
    resultSel.innerHTML = '<option value="" disabled selected>Searching...</option>';
    searchIn.value = '';
  }

  let timer;
  searchIn.addEventListener('input', () => {
    clearTimeout(timer);
    const q = searchIn.value.trim();
    if (q.length < 2) return;
    timer = setTimeout(() => {
      const url = mode === 'damaged'
        ? '{{ route("inventory.fetchProducts") }}?q=' + encodeURIComponent(q)
        : '{{ route("inventory.fetchSales")   }}?q=' + encodeURIComponent(q);
      fetch(url)
        .then(r => r.ok ? r.json() : Promise.reject(r.statusText))
        .then(items => {
          resultSel.innerHTML = '<option value="" disabled selected>Select an item</option>';
          items.forEach(it => {
            const text = mode === 'damaged'
              ? `${it.product_name} (Stock: ${it.stock})`
              : `${it.customer_name} – ${it.product_name} (${it.quantity})`;
            resultSel.innerHTML += `<option value="${it.id}">${text}</option>`;
          });
        })
        .catch(console.error);
    }, 300);
  });

  reason.addEventListener('change', configure);
  configure();
});
</script>
