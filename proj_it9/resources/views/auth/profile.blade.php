<!-- filepath: c:\laravel\pos motor and vechicle parts\it9_proj\proj_it9\resources\views\auth\profile.blade.php -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="profileModalLabel">Profile Settings</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body row g-3">
                    <h6 class="text-muted">Personal Information</h6>
                    <div class="col-md-6">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ Auth::user()->employee->first_name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ Auth::user()->employee->last_name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ Auth::user()->employee->email }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ Auth::user()->employee->phone }}" required>
                    </div>
                    <div class="col-md-12">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" value="{{ Auth::user()->employee->address }}" required>
                    </div>

                    <hr class="my-3">

                    <h6 class="text-muted">Change Password</h6>
                    <div class="col-md-6">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>