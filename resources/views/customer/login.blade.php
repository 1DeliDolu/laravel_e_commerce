<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer Login - E-Commerce</title>
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- FontAwesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
            }

            .login-card {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
                border-radius: 20px;
            }

            .form-control:focus {
                border-color: #fd7e14;
                box-shadow: 0 0 0 0.2rem rgba(253, 126, 20, 0.25);
            }

            .btn-login {
                background: linear-gradient(45deg, #667eea, #764ba2);
                border: none;
            }

            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            .welcome-icon {
                font-size: 4rem;
                background: linear-gradient(45deg, #667eea, #764ba2);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100 py-4">
            <div class="row w-100">
                <div class="col-12 col-md-6 col-lg-5 col-xl-4 mx-auto">
                    <div class="card login-card border-0 shadow-lg">
                        <div class="card-header border-0 bg-transparent pt-5 text-center">
                            <div class="welcome-icon mb-3">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h2 class="fw-bold text-dark mb-2">Welcome Back!</h2>
                            <p class="text-muted mb-0">Sign in to your account</p>
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

                            <form class="needs-validation" action="{{ route('customer.post.login') }}" method="POST"
                                novalidate>
                                @csrf

                                <!-- Email -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold" for="email">
                                        <i class="fas fa-envelope text-primary me-2"></i>Email Address
                                    </label>
                                    <input class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        id="email" name="email" type="email" value="{{ old('email') }}"
                                        placeholder="Enter your email address" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold" for="password">
                                        <i class="fas fa-lock text-primary me-2"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <input
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            id="password" name="password" type="password"
                                            placeholder="Enter your password" required>
                                        <button class="btn btn-outline-secondary" id="togglePassword" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Remember Me -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" id="remember" name="remember" type="checkbox"
                                            value="1">
                                        <label class="form-check-label text-muted" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    <a class="text-decoration-none text-primary small" href="#">
                                        Forgot password?
                                    </a>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mb-4">
                                    <button class="btn btn-primary btn-lg btn-login shadow" type="submit">
                                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                    </button>
                                </div>

                                <!-- Divider -->
                                <div class="mb-3 text-center">
                                    <div class="d-flex align-items-center">
                                        <hr class="flex-grow-1">
                                        <span class="text-muted small px-3">OR</span>
                                        <hr class="flex-grow-1">
                                    </div>
                                </div>

                                <!-- Register Link -->
                                <div class="text-center">
                                    <p class="text-muted mb-0">
                                        Don't have an account?
                                        <a class="text-decoration-none fw-semibold text-primary"
                                            href="{{ route('register') }}">
                                            Create one here
                                        </a>
                                    </p>
                                </div>

                                <!-- Back to Home -->
                                <div class="mt-3 text-center">
                                    <a class="text-decoration-none text-muted small me-3" href="/">
                                        <i class="fas fa-arrow-left me-1"></i>Back to Homepage
                                    </a>
                                    <span class="text-muted">|</span>
                                    <a class="text-decoration-none text-muted small ms-3" href="{{ route('login') }}">
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

        <!-- Password Toggle Script -->
        <script>
            document.getElementById('togglePassword').addEventListener('click', function() {
                const passwordField = document.getElementById('password');
                const icon = this.querySelector('i');

                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });

            // Form validation
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    var forms = document.getElementsByClassName('needs-validation');
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        </script>
    </body>

</html>
