<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer Dashboard - E-Commerce</title>
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- FontAwesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
            }

            .dashboard-card {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
                border-radius: 20px;
            }

            .stats-card {
                background: linear-gradient(45deg, #667eea, #764ba2);
                border-radius: 15px;
                color: white;
            }

            .profile-avatar {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background: linear-gradient(45deg, #667eea, #764ba2);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                color: white;
                margin: 0 auto;
            }

            .nav-pills .nav-link.active {
                background: linear-gradient(45deg, #667eea, #764ba2);
            }

            .btn-custom {
                background: linear-gradient(45deg, #667eea, #764ba2);
                border: none;
                color: white;
            }

            .btn-custom:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                color: white;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card dashboard-card border-0 shadow-lg">
                        <!-- Header -->
                        <div class="card-header border-0 bg-transparent py-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h2 class="fw-bold text-dark mb-0">
                                        <i class="fas fa-tachometer-alt text-primary me-2"></i>
                                        Customer Dashboard
                                    </h2>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a class="btn btn-outline-secondary me-2" href="{{ url('/') }}">
                                        <i class="fas fa-home me-1"></i>Homepage
                                    </a>
                                    <a class="btn btn-danger" href="#"
                                        onclick="event.preventDefault(); document.getElementById('customer-logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                                    </a>
                                    <form id="customer-logout-form" style="display: none;"
                                        action="{{ route('customer.logout') }}" method="POST">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body px-5">
                            <!-- Success/Error Messages -->
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button class="btn-close" data-bs-dismiss="alert" type="button"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ session('error') }}
                                    <button class="btn-close" data-bs-dismiss="alert" type="button"></button>
                                </div>
                            @endif

                            <!-- Welcome Section -->
                            <div class="row mb-4">
                                <div class="col-md-3 text-center">
                                    <div class="profile-avatar mb-3">
                                        {{ strtoupper(substr($customer->first_name, 0, 1)) }}{{ strtoupper(substr($customer->last_name, 0, 1)) }}
                                    </div>
                                    <h5 class="fw-bold">{{ $customer->first_name }} {{ $customer->last_name }}</h5>
                                    <p class="text-muted">{{ $customer->email }}</p>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card stats-card border-0 p-3 text-center">
                                                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                                <h4 class="fw-bold mb-1">{{ $customer->total_orders }}</h4>
                                                <small>Total Orders</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card stats-card border-0 p-3 text-center">
                                                <i class="fas fa-dollar-sign fa-2x mb-2"></i>
                                                <h4 class="fw-bold mb-1">
                                                    ${{ number_format($customer->total_spent, 2) }}
                                                </h4>
                                                <small>Total Spent</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card stats-card border-0 p-3 text-center">
                                                <i class="fas fa-calendar fa-2x mb-2"></i>
                                                <h4 class="fw-bold mb-1">{{ $customer->created_at->format('M Y') }}
                                                </h4>
                                                <small>Member Since</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation Tabs -->
                            <ul class="nav nav-pills mb-4" id="dashboardTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#profile" type="button" role="tab">
                                        <i class="fas fa-user me-1"></i>Profile
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="orders-tab" data-bs-toggle="pill"
                                        data-bs-target="#orders" type="button" role="tab">
                                        <i class="fas fa-shopping-bag me-1"></i>Orders
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="cart-tab" data-bs-toggle="pill" data-bs-target="#cart"
                                        type="button" role="tab">
                                        <i class="fas fa-shopping-cart me-1"></i>Shopping Cart
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="settings-tab" data-bs-toggle="pill"
                                        data-bs-target="#settings" type="button" role="tab">
                                        <i class="fas fa-cog me-1"></i>Settings
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content" id="dashboardTabsContent">
                                <!-- Profile Tab -->
                                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5 class="fw-bold mb-3">Profile Information</h5>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">First Name</label>
                                                    <input class="form-control" type="text"
                                                        value="{{ $customer->first_name }}" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Last Name</label>
                                                    <input class="form-control" type="text"
                                                        value="{{ $customer->last_name }}" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Email Address</label>
                                                <input class="form-control" type="email"
                                                    value="{{ $customer->email }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Phone Number</label>
                                                <input class="form-control" type="text"
                                                    value="{{ $customer->phone ?? 'Not provided' }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Address</label>
                                                <textarea class="form-control" rows="3" readonly>{{ $customer->address ?? 'Not provided' }}</textarea>
                                            </div>
                                            <a class="btn btn-custom" href="{{ route('customer.edit') }}">
                                                <i class="fas fa-edit me-1"></i>Edit Profile
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <h5 class="fw-bold mb-3">Account Summary</h5>
                                            <div class="card bg-light border-0">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span>Account Status:</span>
                                                        <span class="badge bg-success">Active</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span>Joined:</span>
                                                        <span>{{ $customer->created_at->format('M d, Y') }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span>Last Login:</span>
                                                        <span>{{ now()->format('M d, Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Orders Tab -->
                                <div class="tab-pane fade" id="orders" role="tabpanel">
                                    <h5 class="fw-bold mb-3">Order History</h5>
                                    <div class="py-5 text-center">
                                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">No orders yet</h6>
                                        <p class="text-muted">Start shopping to see your orders here!</p>
                                        <a class="btn btn-custom" href="{{ url('/') }}">
                                            <i class="fas fa-shopping-cart me-1"></i>Start Shopping
                                        </a>
                                    </div>
                                </div>

                                <!-- Cart Tab -->
                                <div class="tab-pane fade" id="cart" role="tabpanel">
                                    <h5 class="fw-bold mb-3">Shopping Cart</h5>
                                    <div class="py-5 text-center">
                                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">Your cart is empty</h6>
                                        <p class="text-muted">Add some products to your cart to see them here!</p>
                                        <a class="btn btn-custom" href="{{ url('/') }}">
                                            <i class="fas fa-shopping-cart me-1"></i>Continue Shopping
                                        </a>
                                    </div>
                                </div>

                                <!-- Settings Tab -->
                                <div class="tab-pane fade" id="settings" role="tabpanel">
                                    <h5 class="fw-bold mb-3">Account Settings</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card bg-light mb-3 border-0">
                                                <div class="card-body">
                                                    <h6 class="fw-bold">
                                                        <i class="fas fa-key text-primary me-2"></i>Change Password
                                                    </h6>
                                                    <p class="text-muted small mb-3">Update your account password</p>
                                                    <button class="btn btn-custom btn-sm">Change Password</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-light mb-3 border-0">
                                                <div class="card-body">
                                                    <h6 class="fw-bold">
                                                        <i class="fas fa-bell text-primary me-2"></i>Notifications
                                                    </h6>
                                                    <p class="text-muted small mb-3">Manage your notification
                                                        preferences</p>
                                                    <button class="btn btn-custom btn-sm">Manage Notifications</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-light mb-3 border-0">
                                                <div class="card-body">
                                                    <h6 class="fw-bold">
                                                        <i class="fas fa-shield-alt text-primary me-2"></i>Privacy
                                                        Settings
                                                    </h6>
                                                    <p class="text-muted small mb-3">Control your privacy preferences
                                                    </p>
                                                    <button class="btn btn-custom btn-sm">Privacy Settings</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-light mb-3 border-0">
                                                <div class="card-body">
                                                    <h6 class="fw-bold text-danger">
                                                        <i class="fas fa-trash me-2"></i>Delete Account
                                                    </h6>
                                                    <p class="text-muted small mb-3">Permanently delete your account
                                                    </p>
                                                    <button class="btn btn-outline-danger btn-sm">Delete
                                                        Account</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
