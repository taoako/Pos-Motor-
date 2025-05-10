<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white">
    <div class="container mt-5">
        <h2 class="text-xl font-bold mb-4">Add Product</h2>

        <!-- Back Button -->
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Product Name</label>
                <input name="product_name" class="form-control" required value="{{ old('product_name') }}">
            </div>
            <div class="mb-3">
                <label>Brand</label>
                <input name="brand" class="form-control" value="{{ old('brand') }}">
            </div>
            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
                <button type="button" id="add-category" class="btn btn-success ms-2">Add Category</button>

            </div>

            <div class="mb-3">
                <label>Image</label>
                <input name="image" type="file" class="form-control">
            </div>
            <button class="btn btn-primary">Save</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <!-- JavaScript for Adding New Category -->
    <script>
        document.getElementById('add-category').addEventListener('click', function() {
            const categoryName = prompt('Enter new category name:');
            if (categoryName) {
                fetch("{{ route('categories.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            category_name: categoryName
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const select = document.querySelector('select[name="category_id"]');
                        const option = document.createElement('option');
                        option.value = data.id;
                        option.textContent = data.category_name;
                        select.appendChild(option);
                        select.value = data.id;
                        alert('Category added successfully!');
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


</html>