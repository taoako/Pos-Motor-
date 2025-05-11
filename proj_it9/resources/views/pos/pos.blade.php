<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>
    body { background-color: #1a202c; color: #e2e8f0; }
    .product-card { transition: transform .3s, box-shadow .3s; }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,.3); }
    .btn-hover { transition: background-color .3s, transform .3s; }
    .btn-hover:hover { transform: scale(1.03); }
    @media print {
      body *:not(.print-area) { display: none !important; }
      .print-area { position: absolute; top: 0; left:0; width:100%; }
    }
  </style>
  <script>
    const allProducts   = @json($products->toArray());
    const allCategories = @json($categories->toArray());
    const allCustomers  = @json($customers->toArray());
    const orderStoreUrl = @json(route('order.store'));
    const csrfToken     = @json(csrf_token());
  </script>
</head>
<body class="p-6" x-data="posApp()">

  <div class="flex space-x-6">
    <!-- Products Grid -->
    <div class="w-2/3 grid grid-cols-3 gap-6">
      <template x-for="product in filteredProducts" :key="product.id">
        <div class="product-card bg-gray-800 rounded-lg p-4 text-center">
          <img :src="'/storage/'+product.image" class="h-24 mx-auto mb-2">
          <h3 x-text="product.product_name" class="font-bold text-lg"></h3>
          <p class="text-sm text-gray-400">PHP <span x-text="product.selling_price"></span></p>
          <button @click="addToOrder(product)"
                  class="mt-2 bg-indigo-600 text-white px-3 py-2 rounded btn-hover">
            + Add
          </button>
        </div>
      </template>
    </div>

    <!-- Sidebar: Form, Order & Receipt -->
    <div class="w-1/3 flex flex-col space-y-6">

      <!-- 1) Customer Form -->
      <div class="bg-gray-800 p-4 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Customer Info</h2>
        <form @submit.prevent class="space-y-3">
          <div>
            <label class="block text-sm">Name</label>
            <input x-model="customer.name" type="text"
                   class="w-full mt-1 px-3 py-2 bg-gray-700 rounded" required>
          </div>
          <div>
            <label class="block text-sm">Contact #</label>
            <input x-model="customer.contact" type="tel"
                   class="w-full mt-1 px-3 py-2 bg-gray-700 rounded" required>
          </div>
          <div>
            <label class="block text-sm">Email</label>
            <input x-model="customer.email" type="email"
                   class="w-full mt-1 px-3 py-2 bg-gray-700 rounded">
          </div>
        </form>
      </div>

      <!-- 2) Order Summary -->
      <div class="bg-gray-800 p-4 rounded-lg shadow flex-1 flex flex-col">
        <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
        <ul class="flex-1 overflow-y-auto space-y-2">
          <template x-for="item in orders" :key="item.id">
            <li class="flex justify-between items-center">
              <div>
                <span x-text="item.product_name"></span>
                <span class="text-sm text-gray-400">× <span x-text="item.quantity"></span></span>
              </div>
              <div class="text-right">
                PHP <span x-text="(item.quantity * item.selling_price).toFixed(2)"></span>
              </div>
            </li>
          </template>
        </ul>
        <div class="mt-4 border-t border-gray-700 pt-3">
          <div class="flex justify-between font-semibold">
            <span>Total:</span>
            <span>PHP <span x-text="totalAmount.toFixed(2)"></span></span>
          </div>
          <button @click="submitOrder"
                  class="mt-4 w-full bg-green-600 py-2 rounded btn-hover">
            Submit Order
          </button>
        </div>
      </div>

      <!-- 3) Printable Receipt -->
      <div class="bg-gray-800 p-4 rounded-lg shadow print-area">
        <h2 class="text-lg font-semibold mb-2">Receipt</h2>
        <p><strong>Customer:</strong> <span x-text="customer.name || 'Walk-in'"></span></p>
        <p><strong>Contact:</strong> <span x-text="customer.contact || 'N/A'"></span></p>
        <ul class="mt-2 space-y-1">
          <template x-for="item in orders" :key="item.id">
            <li class="flex justify-between">
              <span x-text="item.product_name"></span>
              <span x-text="item.quantity + '×' + item.selling_price"></span>
            </li>
          </template>
        </ul>
        <div class="mt-2 border-t border-gray-700 pt-2 flex justify-between">
          <strong>Total</strong>
          <strong>PHP <span x-text="totalAmount.toFixed(2)"></span></strong>
        </div>
        <button onclick="window.print()"
                class="mt-4 w-full bg-blue-600 py-2 rounded btn-hover">
          Print Receipt
        </button>
      </div>
    </div>
  </div>

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
            : this.products.filter(p => p.category_id == this.selectedCategory)
        },

        addToOrder(p) {
          let it = this.orders.find(i => i.id === p.id);
          it ? it.quantity++ : this.orders.push({ ...p, quantity: 1 });
          this.calculateTotal();
        },

        calculateTotal() {
          this.totalAmount = this.orders.reduce(
            (sum, o) => sum + o.quantity * o.selling_price,
            0
          );
        },

        async submitOrder() {
          // you can include customer data in your payload if you like.
          await fetch(orderStoreUrl, {
            method: 'POST',
            headers: { 'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken },
            body: JSON.stringify({
              customer: this.customer,
              orders: this.orders,
              total_amount: this.totalAmount,
              payment_method: this.paymentMethod
            })
          });
          alert('Order submitted!');
        }
      }
    }
  </script>

</body>
</html>
