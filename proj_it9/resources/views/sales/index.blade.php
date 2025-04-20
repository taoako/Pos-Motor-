<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Sales</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom animation for table rows */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Apply the fadeInUp animation to table rows */
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Button hover effect */
        .btn-hover {
            transition: all 0.3s ease-in-out;
        }

        .btn-hover:hover {
            transform: scale(1.1);
            background-color: #4CAF50;
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.6);
        }
    </style>
</head>

<body class="bg-gray-900 text-white">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-white mb-6 text-center animate__animated animate__fadeInUp">Sales List</h1>

        <table class="table-auto w-full text-white shadow-lg rounded-lg bg-gray-800">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Product ID</th>
                    <th class="border px-4 py-2">Quantity</th>
                    <th class="border px-4 py-2">Price</th>
                    <th class="border px-4 py-2">Total</th>
                    <th class="border px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr class="fade-in-up">
                        <td class="border px-4 py-2">{{ $sale->product_id }}</td>
                        <td class="border px-4 py-2">{{ $sale->quantity }}</td>
                        <td class="border px-4 py-2">{{ $sale->price }}</td>
                        <td class="border px-4 py-2">{{ $sale->total }}</td>
                        <td class="border px-4 py-2">{{ $sale->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6 text-center">
            <a href="{{ route('dashboard') }}" class="bg-gray-700 text-white py-2 px-6 rounded-full hover:bg-gray-600 transition duration-300 ease-in-out transform hover:scale-105">Back to Dashboard</a>
        </div>
    </div>

</body>

</html>
