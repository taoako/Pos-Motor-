<body>
    <div class="container py-5">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="text-center mb-4">
            <h2 class="fw-bold">Employee & User Registration</h2>
        </div>

        <!-- Trigger button (so you can actually open it!) -->
        <button class="btn btn-dark mb-4" data-bs-toggle="modal" data-bs-target="#registerModal">
            Open Registration
        </button>

        <!-- Registration Modal -->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="registerModalLabel">Register Employee & User</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('register.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <h6 class="text-muted">Employee Information</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-dark">First Name</label>
                                    <input type="text" name="first_name" class="form-control bg-light text-dark" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark">Last Name</label>
                                    <input type="text" name="last_name" class="form-control bg-light text-dark" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark">Email</label>
                                    <input type="email" name="email" class="form-control bg-light text-dark" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark">Phone</label>
                                    <input type="text" name="phone" class="form-control bg-light text-dark" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-dark">Address</label>
                                    <input type="text" name="address" class="form-control bg-light text-dark" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark">Position</label>
                                    <select name="position" class="form-select bg-light text-dark" required>
                                        <option value="">-- Select Position --</option>
                                        <option>Admin</option>
                                        <option>Cashier</option>
                                        <option>Inventory Staff</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-3">

                            <h6 class="text-muted">User Account</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-dark">Username</label>
                                    <input type="text" name="username" class="form-control bg-light text-dark" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark">Password</label>
                                    <input type="password" name="password" class="form-control bg-light text-dark" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control bg-light text-dark" required>
                                </div>

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

    <!-- Bootstrap JS (after your HTML) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>