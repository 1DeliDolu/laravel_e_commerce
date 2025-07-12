@extends('admin.main_design')

@section('add_product')
    <!-- Modern Alert Messages -->
    @if (session('product_add'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('product_add') }}
            <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
        </div>
    @elseif (session('product_error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('product_error') }}
            <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Validation Errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
        </div>
    @endif

    <!-- Modern Container with Full Screen Background -->
    <div class="position-absolute w-100 vh-100 d-flex align-items-center justify-content-center start-0 top-0"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); overflow-y: auto; z-index: 1000;">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <!-- Modern Card with Glass Effect -->
                    <div class="card border-0shadow-lg my-4"
                        style="backdrop-filter: blur(10px); background: rgba(157, 154, 154, 0.95)rder-radius: 20px;">
                        <div class="card-header border-0 bg-transparent pb-3 pt-4 text-center">
                            <div class="mb-3">

                            </div>
                            <h2 class="card-title fw-bold mb-2">Add New Product</h2>
                            <p class="text-muted mb-0">Fill out the form below to add a new product to the database</p>
                        </div>

                        <div class="card-body px-5 pb-5">
                            <form class="needs-validation" action="{{ route('post_add_product') }}" method="POST"
                                enctype="multipart/form-data" novalidate>
                                @csrf

                                <!-- Product Title -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        Product Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        class="form-control form-control-lg @error('product_title') is-invalid @enderror border-0 shadow-sm"
                                        name="product_title" type="text" value="{{ old('product_title') }}"
                                        style="border-radius: 12px; background: #f8f9fa;"
                                        placeholder="Enter product title..." maxlength="255" required>
                                    @error('product_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Please enter the product title (maximum 255 characters).</div>
                                    @enderror
                                    <small class="form-text text-muted">Enter a descriptive title for your product</small>
                                </div>

                                <!-- Product Description -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        Product Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control form-control-lg @error('product_description') is-invalid @enderror border-0 shadow-sm"
                                        name="product_description" style="border-radius: 12px; background: #f8f9fa; resize: vertical;" rows="4"
                                        placeholder="Describe your product in detail..." required>{{ old('product_description') }}</textarea>
                                    @error('product_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Please enter the product description.</div>
                                    @enderror
                                    <small class="form-text text-muted">Describe the features, benefits, and uses of your product</small>
                                </div>

                                <!-- Product Images Upload -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        <i class="fas fa-images text-primary me-2"></i>Product Images
                                        <span class="text-muted">(Optional)</span>
                                    </label>
                                    <div class="image-upload-container">
                                        <input class="form-control @error('product_images.*') is-invalid @enderror"
                                            id="productImages" name="product_images[]" type="file"
                                            style="border-radius: 12px; background: #fff7ed; border: 2px solid #fed7aa;"
                                            multiple accept="image/jpeg,image/png,image/jpg,image/gif">

                                        @error('product_images.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <small class="form-text text-muted">
                                            You can select multiple images (JPEG, PNG, JPG, GIF - Maximum 2MB each)
                                        </small>

                                        <!-- Image Preview Container -->
                                        <div class="row mt-3" id="imagePreviewContainer"></div>
                                    </div>
                                </div>

                                <!-- Quantity and Price Row -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-dark mb-2">
                                            <i class="fas fa-boxes text-primary me-2"></i>Stock Quantity
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control form-control-lg @error('product_quantity') is-invalid @enderror border-0 shadow-sm"
                                            name="product_quantity" type="number" value="{{ old('product_quantity') }}"
                                            style="border-radius: 12px; background: #f8f9fa;" min="0" max="999999"
                                            placeholder="0" required>
                                        @error('product_quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="invalid-feedback">Please enter a valid quantity (0 or greater).
                                            </div>
                                        @enderror
                                        <small class="form-text text-muted">Available stock quantity</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-dark mb-2">
                                            <i class="fas fa-lira-sign text-primary me-2"></i>Price (₺)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control form-control-lg @error('product_price') is-invalid @enderror border-0 shadow-sm"
                                            name="product_price" type="number" value="{{ old('product_price') }}"
                                            style="border-radius: 12px; background: #f8f9fa;" step="0.01"
                                            min="0" max="99999999.99" placeholder="0.00" required>
                                        @error('product_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="invalid-feedback">Please enter a valid price (0.00 - 99,999,999.99).
                                            </div>
                                        @enderror
                                        <small class="form-text text-muted">Product sale price (including VAT)</small>
                                    </div>
                                </div>


                                <!-- Category Selection -->
                                <div class="mb-5">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        Category
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="w-100">
                                        <select
                                            class="form-select-lg @error('product_category') is-invalid @enderror w-100 form-select border-0 shadow-sm"
                                            name="product_category"
                                            style="border-radius: 12px; background: #f8f9fa; color: #333; width: 100%;"
                                            required>
                                            <option value="" disabled
                                                {{ old('product_category') ? '' : 'selected' }}>
                                                Select a category...
                                            </option>
                                            @if (isset($categories) && count($categories) > 0)
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        style="color: #333; background: #fff;"
                                                        {{ old('product_category') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->category }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option disabled>No categories available yet</option>
                                            @endif
                                        </select>
                                    </div>
                                    @error('product_category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Please select a category.</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Select the category your product belongs to.
                                        @if (!isset($categories) || count($categories) == 0)
                                            <a class="text-primary" href="{{ route('add_category') }}">Click here to add your first category.</a>
                                        @endif
                                    </small>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <a class="btn btn-outline-secondary btn-lg border-0 px-4 py-2"
                                        href="{{ route('view_product') }}"
                                        style="border-radius: 12px; background: rgba(171, 173, 174, 0.1);">
                                        Back to Products
                                    </a>
                                    <button class="btn btn-primary btn-lg px-5 py-2 shadow-lg" type="submit"
                                        style="border-radius: 12px; background: linear-gradient(45deg, #667eea, #764ba2); border: none;">
                                        Save Product
                                    </button>
                                </div>

                                <!-- Required Fields Note -->
                                <div class="mt-3 text-center">
                                    <small class="text-muted">
                                        <span class="text-danger">*</span> fields are required
                                    </small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .form-control:focus,
        .form-select:focus {
            border-color: #fd7e14;
            box-shadow: 0 0 0 0.2rem rgba(253, 126, 20, 0.25);
            background: #fff9f4 !important;
        }

        .form-control,
        .form-select {
            background: #fff7ed !important;
            border: 2px solid #fed7aa;
            transition: all 0.3s ease;
        }

        .form-control:hover,
        .form-select:hover {
            border-color: #fb923c;
            background: #fff9f4 !important;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4) !important;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: rgba(108, 117, 125, 0.2) !important;
            border-color: transparent !important;
            transition: all 0.3s ease;
        }

        .card {
            transition: all 0.3s ease;
        }

        .alert {
            border-left: 4px solid;
            border-radius: 12px !important;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            max-width: 400px;
        }

        .alert-success {
            border-left-color: #28a745;
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.05));
        }

        .alert-danger {
            border-left-color: #dc3545;
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.05));
        }

        .invalid-feedback {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }

        .was-validated .form-control:invalid,
        .was-validated .form-select:invalid,
        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545;
            background: rgba(220, 53, 69, 0.1) !important;
        }

        .was-validated .form-control:valid,
        .was-validated .form-select:valid,
        .form-control.is-valid,
        .form-select.is-valid {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.1) !important;
        }

        .form-text {
            font-size: 0.825rem;
            margin-top: 0.25rem;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        /* Orange themed input styling */
        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            border-color: #fd7e14 !important;
            box-shadow: 0 0 0 0.2rem rgba(253, 126, 20, 0.25) !important;
            background: #fff9f4 !important;
        }

        /* Input placeholder styling */
        .form-control::placeholder,
        .form-select option:first-child {
            color: #fb923c;
            opacity: 0.7;
        }

        /* Custom number input styling */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Orange accent for labels */
        .form-label {
            color: #ea580c !important;
        }

        /* Loading state for form submission */
        .btn-primary:disabled {
            background: #6c757d;
            border-color: #6c757d;
            cursor: not-allowed;
        }

        /* Orange border for input containers */
        .form-control,
        .form-select {
            border-radius: 12px !important;
        }

        /* Active state styling */
        .form-control:active,
        .form-select:active {
            border-color: #ea580c !important;
            background: #fff9f4 !important;
        }

        /* Image upload styling */
        .image-upload-container .form-control:hover {
            border-color: #fb923c !important;
            background: #fff9f4 !important;
        }

        .image-preview {
            position: relative;
            margin-bottom: 1rem;
        }

        .image-preview img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #fed7aa;
            transition: all 0.3s ease;
        }

        .image-preview img:hover {
            border-color: #fd7e14;
            transform: scale(1.02);
        }

        .image-preview .remove-image {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .image-preview .remove-image:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        .drag-drop-area {
            border: 2px dashed #fed7aa;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            background: #fff7ed;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .drag-drop-area.drag-over {
            border-color: #fd7e14;
            background: #fff9f4;
        }

        .drag-drop-area:hover {
            border-color: #fb923c;
            background: #fff9f4;
        }
    </style>

    <!-- Form Validation and Enhancement Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            'use strict';

            // Bootstrap form validation
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        // Show loading state
                        var submitBtn = form.querySelector('button[type="submit"]');
                        submitBtn.disabled = true;
                        submitBtn.innerHTML =
                            '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                    }
                    form.classList.add('was-validated');
                }, false);
            });

            // Image upload preview functionality
            const imageInput = document.getElementById('productImages');
            const previewContainer = document.getElementById('imagePreviewContainer');
            let selectedFiles = [];

            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    handleFiles(e.target.files);
                });

                // Drag and drop functionality
                const uploadContainer = imageInput.closest('.image-upload-container');
                uploadContainer.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    uploadContainer.classList.add('drag-over');
                });

                uploadContainer.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    uploadContainer.classList.remove('drag-over');
                });

                uploadContainer.addEventListener('drop', function(e) {
                    e.preventDefault();
                    uploadContainer.classList.remove('drag-over');
                    handleFiles(e.dataTransfer.files);
                });
            }

            function handleFiles(files) {
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        // Check file size (2MB limit)
                        if (file.size > 2 * 1024 * 1024) {
                            alert(`${file.name} is too large. Maximum size is 2MB.`);
                            return;
                        }

                        selectedFiles.push(file);
                        displayImagePreview(file);
                    } else {
                        alert(`${file.name} is not a valid image file.`);
                    }
                });

                updateFileInput();
            }

            function displayImagePreview(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 col-sm-4 col-6';

                    col.innerHTML = `
                        <div class="image-preview">
                            <img src="${e.target.result}" alt="Preview" />
                            <button type="button" class="remove-image" onclick="removeImage(this, '${file.name}')">
                                <i class="fas fa-times"></i>
                            </button>
                            <small class="d-block text-center text-muted mt-1">${file.name}</small>
                        </div>
                    `;

                    previewContainer.appendChild(col);
                };
                reader.readAsDataURL(file);
            }

            window.removeImage = function(button, fileName) {
                // Remove from selectedFiles array
                selectedFiles = selectedFiles.filter(file => file.name !== fileName);

                // Remove preview element
                const previewElement = button.closest('.col-md-3, .col-sm-4, .col-6');
                previewElement.remove();

                // Update file input
                updateFileInput();
            };

            function updateFileInput() {
                // Create new FileList with remaining files
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                imageInput.files = dt.files;
            }

            // Auto-format price input
            var priceInput = document.querySelector('input[name="product_price"]');
            if (priceInput) {
                priceInput.addEventListener('blur', function() {
                    if (this.value && !isNaN(this.value)) {
                        this.value = parseFloat(this.value).toFixed(2);
                    }
                });
            }

            // Auto-dismiss alerts after 5 seconds
            var alerts = document.querySelectorAll('.alert:not(.alert-danger)');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    if (alert.classList.contains('show')) {
                        var bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            });

            // Character counter for product title
            var titleInput = document.querySelector('input[name="product_title"]');
            if (titleInput) {
                var maxLength = titleInput.getAttribute('maxlength');
                var helpText = titleInput.parentNode.querySelector('.form-text');

                titleInput.addEventListener('input', function() {
                    var remaining = maxLength - this.value.length;
                    helpText.textContent =
                        `Enter a descriptive title for your product (${remaining} characters left)`;

                    if (remaining < 20) {
                        helpText.classList.add('text-warning');
                        helpText.classList.remove('text-muted');
                    } else {
                        helpText.classList.add('text-muted');
                        helpText.classList.remove('text-warning');
                    }
                });
            }
        });
    </script>
@endsection
