<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer Registration - E-Commerce</title>
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- FontAwesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
            }

            .register-card {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
                border-radius: 20px;
            }

            .form-control:focus {
                border-color: #fd7e14;
                box-shadow: 0 0 0 0.2rem rgba(253, 126, 20, 0.25);
            }

            .btn-register {
                background: linear-gradient(45deg, #667eea, #764ba2);
                border: none;
            }

            .btn-register:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }
        </style>
    </head>

    <body>
        <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100 py-4">
            <div class="row w-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 mx-auto">
                    <div class="card register-card border-0 shadow-lg">
                        <div class="card-header border-0 bg-transparent pt-4 text-center">
                            <h2 class="fw-bold text-dark mb-2">
                                <i class="fas fa-user-plus text-primary me-2"></i>
                                Create Account
                            </h2>
                            <p class="text-muted mb-0">Join our e-commerce platform</p>
                        </div>

                        <div class="card-body px-5 pb-5">
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

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Validation Errors:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button class="btn-close" data-bs-dismiss="alert" type="button"></button>
                                </div>
                            @endif

                            <form class="needs-validation" action="{{ route('customer.post.register') }}" method="POST"
                                novalidate>
                                @csrf

                                <!-- Name Fields -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="first_name">
                                            <i class="fas fa-user text-primary me-1"></i>First Name <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input class="form-control @error('first_name') is-invalid @enderror"
                                            id="first_name" name="first_name" type="text"
                                            value="{{ old('first_name') }}" placeholder="Enter your first name"
                                            required>
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="last_name">
                                            <i class="fas fa-user text-primary me-1"></i>Last Name <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input class="form-control @error('last_name') is-invalid @enderror"
                                            id="last_name" name="last_name" type="text"
                                            value="{{ old('last_name') }}" placeholder="Enter your last name" required>
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" for="email">
                                        <i class="fas fa-envelope text-primary me-1"></i>Email Address <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" type="email" value="{{ old('email') }}"
                                        placeholder="Enter your email address" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password Fields -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="password">
                                            <i class="fas fa-lock text-primary me-1"></i>Password <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" type="password"
                                            placeholder="Enter your password" minlength="8" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="password_confirmation">
                                            <i class="fas fa-lock text-primary me-1"></i>Confirm Password <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" id="password_confirmation"
                                            name="password_confirmation" type="password"
                                            placeholder="Confirm your password" minlength="8" required>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" for="phone">
                                        <i class="fas fa-phone text-primary me-1"></i>Phone Number
                                    </label>
                                    <input class="form-control @error('phone') is-invalid @enderror" id="phone"
                                        name="phone" type="tel" value="{{ old('phone') }}"
                                        placeholder="Enter your phone number">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <!-- Address Fields (US Style) -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" for="street_address">
                                        <i class="fas fa-map-marker-alt text-primary me-1"></i>Street Address <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input class="form-control @error('street_address') is-invalid @enderror"
                                        id="street_address" name="street_address" type="text"
                                        value="{{ old('street_address') }}" placeholder="123 Main St" required>
                                    @error('street_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="city">
                                            <i class="fas fa-city text-primary me-1"></i>City <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input class="form-control @error('city') is-invalid @enderror" id="city"
                                            name="city" type="text" value="{{ old('city') }}"
                                            placeholder="City" required>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold" for="state">
                                            <i class="fas fa-flag-usa text-primary me-1"></i>State <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input class="form-control @error('state') is-invalid @enderror"
                                            id="state" name="state" type="text"
                                            value="{{ old('state') }}" placeholder="State" required>
                                        @error('state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold" for="zip">
                                            <i class="fas fa-mail-bulk text-primary me-1"></i>ZIP Code <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input class="form-control @error('zip') is-invalid @enderror" id="zip"
                                            name="zip" type="text" value="{{ old('zip') }}"
                                            placeholder="ZIP" required>
                                        @error('zip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Hidden field to combine address parts -->
                                <input id="address" name="address" type="hidden" value="">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        function updateAddress() {
                                            const street = document.getElementById('street_address').value.trim();
                                            const city = document.getElementById('city').value.trim();
                                            const state = document.getElementById('state').value.trim();
                                            const zip = document.getElementById('zip').value.trim();
                                            let address = '';
                                            if (street) address += street;
                                            if (city) address += ', ' + city;
                                            if (state) address += ', ' + state;
                                            if (zip) address += ' ' + zip;
                                            document.getElementById('address').value = address.trim();
                                        }
                                        ['street_address', 'city', 'state', 'zip'].forEach(function(id) {
                                            document.getElementById(id).addEventListener('input', updateAddress);
                                        });
                                        updateAddress();
                                    });
                                </script>

                                <!-- Submit Button -->
                                <div class="d-grid mb-3">
                                    <button class="btn btn-primary btn-lg btn-register shadow" type="submit">
                                        <i class="fas fa-user-plus me-2"></i>Create Account
                                    </button>
                                </div>

                                <!-- Login Link -->
                                <div class="text-center">
                                    <p class="text-muted mb-0">
                                        Already have an account?
                                        <a class="text-decoration-none fw-semibold text-primary"
                                            href="{{ route('customer.login') }}">
                                            Login here
                                        </a>
                                    </p>
                                </div>

                                <!-- Back to Home -->
                                <div class="mt-3 text-center">
                                    <a class="text-decoration-none text-muted small me-3" href="/">
                                        <i class="fas fa-arrow-left me-1"></i>Back to Homepage
                                    </a>
                                    <span class="text-muted">|</span>
                                    <a class="text-decoration-none text-muted small ms-3"
                                        href="{{ route('login') }}">
                                        <i class="fas fa-user-shield me-1"></i>Admin Login
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
