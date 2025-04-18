<!DOCTYPE html>
<html lang="en">

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<head>
    <meta charset="UTF-8">
    <title>Register Employee & User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
        }

        .card {
            background-color: #e0e0e0;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Employee & User Registration</h2>
        </div>



        <!-- Registration Modal -->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="registerModalLabel">Register Employee & User</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('register.store') }}" method="POST">
                        @csrf
                        <div class="modal-body row g-3">
                            <h6 class="text-muted">Employee Information</h6>
                            <div class="col-md-6">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Position</label>
                                <select name="position" class="form-control" required>
                                    <option value="">-- Select Position --</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Cashier">Cashier</option>
                                    <option value="Inventory Staff">Inventory Staff</option>
                                </select>
                            </div>

                            <hr class="my-3">

                            <h6 class="text-muted">User Account</h6>
                            <div class="col-md-6">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-dark">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>