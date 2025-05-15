<!DOCTYPE html>
<html lang="en" x-data="posApp()" class="bg-gray-100 text-gray-800 font-sans">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>POS System</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />

  <script>
    const allProducts = @json($products->toArray());
    const allCategories = @json($categories->toArray());
    const allCustomers = @json($customers->toArray());
    const orderStoreUrl = @json(route('order.store'));
    const csrfToken = @json(csrf_token());
  </script>

  <style>
    ::-webkit-scrollbar {
      width: 6px;
    }

    ::-webkit-scrollbar-thumb {
      background-color: #cbd5e1;
      border-radius: 4px;
    }

    @media print {
      body *:not(.print-area) {
        display: none !important;
      }

      .print-area {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
      }
    }
  </style>
</head>

<body class="min-h-screen p-4 lg:p-6 bg-gray-50 text-gray-900 font-sans">
  <!-- Admin Navbar -->
  <nav class="bg-white border-b border-gray-200 px-4 py-2 mb-6 flex items-center justify-between">
    <div class="flex items-center gap-4">
      <span class="font-bold text-blue-700 text-xl">POS System</span>
    </div>
    <div class="flex gap-2">
      @if (Auth::user()->employee->position === 'Admin')
        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded text-blue-700 hover:bg-blue-50 font-semibold">Dashboard</a>
        <a href="{{ route('inventory.content') }}" class="px-3 py-2 rounded text-blue-700 hover:bg-blue-50 font-semibold">Inventory</a>
        <a href="{{ route('products.content') }}" class="px-3 py-2 rounded text-blue-700 hover:bg-blue-50 font-semibold">Products</a>
        <a href="{{ route('suppliers.content') }}" class="px-3 py-2 rounded text-blue-700 hover:bg-blue-50 font-semibold">Suppliers</a>
        <a href="{{ route('employees.content') }}" class="px-3 py-2 rounded text-blue-700 hover:bg-blue-50 font-semibold">Employees</a>
      @endif
      <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="px-3 py-2 rounded bg-red-600 text-white font-semibold">Log Out</button>
      </form>
    </div>
  </nav>

  <div x-data="{ test: 'Hello Alpine!' }">
    <h1 x-text="test" class="text-2xl text-red-500"></h1>
  </div>

  <!-- Header -->
  <header class="bg-white shadow-md py-4 px-6 rounded-lg mb-6 sticky top-0 z-50">
    <h1 class="text-3xl font-bold text-indigo-600 text-center">Point of Sale System</h1>
    <!-- Category Navbar -->
    <nav class="mt-4 flex justify-center space-x-4">
      <button @click="selectedCategory = ''; filterProducts()"
        :class="{'bg-indigo-600 text-white': selectedCategory === '', 'bg-gray-200 text-gray-700': selectedCategory !== ''}"
        class="px-4 py-2 rounded-lg font-medium transition">All</button>
      <template x-for="category in allCategories" :key="category.id">
        <button @click="selectedCategory = category.id; filterProducts()"
          :class="{'bg-indigo-600 text-white': selectedCategory === category.id, 'bg-gray-200 text-gray-700': selectedCategory !== category.id}"
          class="px-4 py-2 rounded-lg font-medium transition" x-text="category.name"></button>
      </template>
    </nav>
  </header>

  <main class="flex flex-col lg:flex-row gap-6">
    <!-- Product List -->
    <section class="lg:w-2/3">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[70vh] overflow-y-auto pr-1">
        <template x-for="product in filteredProducts" :key="product.id">
          <div
            class="bg-white rounded-xl shadow p-4 flex flex-col items-center text-center hover:shadow-lg transition-all duration-200 border border-gray-200">
            <img :src="product.image ? '/storage/' + product.image : 'https://via.placeholder.com/100x100?text=No+Image'" alt="Product"
              class="h-24 w-24 object-cover rounded-full border border-gray-300 mb-3 bg-gray-100" />
            <h3 class="font-medium text-gray-900 text-lg" x-text="product.product_name"></h3>
            <p class="text-gray-600 text-sm">PHP <span x-text="product.selling_price"></span></p>
            <button @click="addToOrder(product)"
              class="mt-3 w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition transform hover:scale-105">
              + Add to Cart
            </button>
          </div>
        </template>
      </div>
    </section>

    <!-- Sidebar -->
    <aside class="lg:w-1/3 flex flex-col gap-6 sticky top-24 self-start">
      <!-- Customer Info -->
      <div class="bg-white rounded-xl shadow p-5 space-y-4">
        <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Customer Info</h2>
        <form @submit.prevent="submitCustomerInfo" class="space-y-3">
          <div>
            <label class="block text-sm mb-1 font-medium">Name</label>
            <input x-model="customer.name" type="text"
              class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm" required />
          </div>
          <div>
            <label class="block text-sm mb-1 font-medium">Contact #</label>
            <input x-model="customer.contact" type="tel"
              class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm" required />
          </div>
          <div>
            <label class="block text-sm mb-1 font-medium">Email</label>
            <input x-model="customer.email" type="email"
              class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm" />
          </div>
          <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium text-sm transition transform hover:scale-105">
            💾 Save Info
          </button>
        </form>
      </div>

      <!-- Order Summary -->
      <div class="bg-white rounded-xl shadow p-5 flex flex-col max-h-[300px] overflow-y-auto">
        <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-3">Order Summary</h2>
        <ul class="flex-1 space-y-2 text-sm">
          <template x-for="item in orders" :key="item . id">
            <li class="flex justify-between items-center">
              <div>
                <span x-text="item.product_name"></span>
                <span class="text-gray-400">× <span x-text="item.quantity"></span></span>
              </div>
              <div class="flex items-center space-x-2">
                <button @click="decreaseQuantity(item)"
                  class="px-2 py-1 bg-gray-200 rounded text-gray-700 hover:bg-gray-300">-</button>
                <span class="text-gray-800 font-medium" x-text="item.quantity"></span>
                <button @click="increaseQuantity(item)"
                  class="px-2 py-1 bg-gray-200 rounded text-gray-700 hover:bg-gray-300">+</button>
              </div>
              <div>PHP <span x-text="(item.quantity * item.selling_price).toFixed(2)"></span></div>
            </li>
          </template>
        </ul>
        <div class="mt-4 border-t pt-3 font-semibold text-gray-800 text-lg flex justify-between">
          <span>Total:</span>
          <span>PHP <span x-text="totalAmount.toFixed(2)"></span></span>
        </div>
        <button @click="submitOrder"
          class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold text-sm transition transform hover:scale-105">
          ✅ Confirm Order
        </button>
      </div>

      <!-- Receipt -->
      <div class="bg-white rounded-xl shadow p-5 print-area">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Receipt</h2>
        <p><strong>Customer:</strong> <span x-text="customer.name || 'Walk-in'"></span></p>
        <p><strong>Contact:</strong> <span x-text="customer.contact || 'N/A'"></span></p>
        <ul class="mt-2 space-y-1 text-sm">
          <template x-for="item in orders" :key="item . id">
            <li class="flex justify-between">
              <span x-text="item.product_name"></span>
              <span x-text="item.quantity + '×' + item.selling_price"></span>
            </li>
          </template>
        </ul>
        <div class="mt-3 border-t pt-2 font-semibold flex justify-between">
          <span>Total</span>
          <span>PHP <span x-text="totalAmount.toFixed(2)"></span></span>
        </div>
        <button onclick="window.print()"
          class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium text-sm transition transform hover:scale-105">
          🖨️ Print Receipt
        </button>
      </div>
    </aside>
  </main>

  <!-- Alpine.js Script -->
  <script>
    function posApp() {
      return {
        products: allProducts,
        filteredProducts: allProducts,
        orders: [],
        customer: { name: '', contact: '', email: '' },
        selectedCategory: '',
        paymentMethod: 'cash',
        totalAmount: 0,

        filterProducts() {
          this.filteredProducts = this.selectedCategory === ''
            ? this.products
            : this.products.filter(p => p.category_id == this.selectedCategory);
        },

        addToOrder(product) {
          let existing = this.orders.find(i => i.id === product.id);
          if (existing) {
            existing.quantity++;
          } else {
            this.orders.push({ ...product, quantity: 1 });
          }
          this.calculateTotal();
        },

        increaseQuantity(item) {
          item.quantity++;
          this.calculateTotal();
        },

        decreaseQuantity(item) {
          if (item.quantity > 1) {
            item.quantity--;
            this.calculateTotal();
          }
        },

        calculateTotal() {
          this.totalAmount = this.orders.reduce(
            (sum, item) => sum + item.quantity * item.selling_price,
            0
          );
        },

        async submitCustomerInfo() {
          try {
            const response = await fetch('{{ route('customers.store') }}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
              },
              body: JSON.stringify(this.customer)
            });

            const data = await response.json();
            alert(response.ok ? data.success : 'Failed to save customer info.');
          } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while saving customer info.');
          }
        },

        async submitOrder() {
          try {
            const response = await fetch(orderStoreUrl, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
              },
              body: JSON.stringify({
                customer_id: this.customer.id || null,
                user_id: @json(auth()->id()),
                transaction_date: new Date().toISOString(),
                total_amount: this.totalAmount,
                payment_method: this.paymentMethod,
                orders: this.orders
              })
            });

            const data = await response.json();
            alert(response.ok ? 'Order submitted successfully!' : 'Failed to submit order.');
            if (response.ok) this.resetOrder();
          } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while submitting the order.');
          }
        },

        resetOrder() {
          this.orders = [];
          this.customer = { name: '', contact: '', email: '' };
          this.totalAmount = 0;
          this.paymentMethod = 'cash';
        }
      }
    }
  </script>
</body>

</html>