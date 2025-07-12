@extends('admin.main_design')

@section('update_product')
    <!-- Modern Alert Messages -->
    @if (session('product_update'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('product_update') }}
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
                    <div class="card my-4 border-0 shadow-lg"
                        style="backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95); border-radius: 20px;">
                        <div class="card-header border-0 bg-transparent pb-3 pt-4 text-center">
                            <h2 class="card-title fw-bold text-dark mb-2">Update Product</h2>
                            <p class="text-muted mb-0">Edit product information in the database</p>
                        </div>

                        <div class="card-body px-5 pb-5">
                            <form class="needs-validation" action="{{ route('update_product', $product->id) }}"
                                method="POST" enctype="multipart/form-data" novalidate>
                                @csrf
                                @method('PUT')

                                <!-- Product Title -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        Product Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        class="form-control form-control-lg @error('product_title') is-invalid @enderror border-0 shadow-sm"
                                        name="product_title" type="text"
                                        value="{{ old('product_title', $product->product_title) }}"
                                        style="border-radius: 12px; background: #f8f9fa;"
                                        placeholder="Enter product title..." maxlength="255" required>
                                    @error('product_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Please enter the product title (maximum 255 characters).
                                        </div>
                                    @enderror
                                </div>

                                <!-- Product Description -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        Product Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control form-control-lg @error('product_description') is-invalid @enderror border-0 shadow-sm"
                                        name="product_description" style="border-radius: 12px; background: #f8f9fa; resize: vertical;" rows="4"
                                        placeholder="Describe your product in detail..." required>{{ old('product_description', $product->product_description) }}</textarea>
                                    @error('product_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Please enter the product description.</div>
                                    @enderror
                                </div>

                                <!-- Current Images Display -->
                                @php
                                    $currentImages = $product->product_images;
                                    if (is_string($currentImages)) {
                                        $currentImages = json_decode($currentImages, true) ?? [];
                                    }
                                    if (!is_array($currentImages)) {
                                        $currentImages = [];
                                    }
                                @endphp

                                @if (!empty($currentImages) && count($currentImages) > 0)
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold text-dark mb-2">
                                            <i class="fas fa-images text-primary me-2"></i>Current Images
                                        </label>
                                        <div class="row">
                                            @foreach ($currentImages as $imagePath)
                                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                                    <div class="current-image-preview position-relative">
                                                        <img class="img-fluid" src="{{ asset($imagePath) }}"
                                                            alt="Current Image"
                                                            style="height: 120px; width: 100%; object-fit: cover; border-radius: 12px; border: 2px solid #fed7aa;">
                                                        <button
                                                            class="btn btn-danger btn-sm position-absolute end-0 top-0 m-1"
                                                            type="button"
                                                            style="border-radius: 50%; width: 25px; height: 25px; padding: 0;"
                                                            onclick="removeCurrentImage(this, '{{ $imagePath }}')">
                                                            <i class="fas fa-times" style="font-size: 0.7rem;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <input id="existingImagesInput" name="existing_images" type="hidden"
                                            value="{{ json_encode($currentImages) }}">
                                    </div>
                                @endif

                                <!-- Product Images Upload -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        <i class="fas fa-images text-primary me-2"></i>Add New Images
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
                                            You can select multiple new images (JPEG, PNG, JPG, GIF - Maximum 2MB each)
                                        </small>

                                        <!-- New Image Preview Container -->
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
                                            name="product_quantity" type="number"
                                            value="{{ old('product_quantity', $product->product_quantity) }}"
                                            style="border-radius: 12px; background: #f8f9fa;" min="0"
                                            max="999999" placeholder="0" required>
                                        @error('product_quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="invalid-feedback">Please enter a valid quantity (0 or greater).</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-dark mb-2">
                                            <i class="fas fa-dollar-sign text-primary me-2"></i>Price ($)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control form-control-lg @error('product_price') is-invalid @enderror border-0 shadow-sm"
                                            name="product_price" type="number"
                                            value="{{ old('product_price', $product->product_price) }}"
                                            style="border-radius: 12px; background: #f8f9fa;" step="0.01"
                                            min="0" max="99999999.99" placeholder="0.00" required>
                                        @error('product_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="invalid-feedback">Please enter a valid price (0.00 - 99,999,999.99).
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Category Selection -->
                                <div class="mb-5">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        Category
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        class="form-select-lg @error('product_category') is-invalid @enderror w-100 form-select border-0 shadow-sm"
                                        name="product_category"
                                        style="border-radius: 12px; background: #f8f9fa; color: #333;" required>
                                        @if (isset($categories) && count($categories) > 0)
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('product_category', $product->product_category) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option disabled>No categories available</option>
                                        @endif
                                    </select>
                                    @error('product_category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Please select a category.</div>
                                    @enderror
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <a class="btn btn-outline-secondary btn-lg border-0 px-4 py-2"
                                        href="{{ route('view_product') }}"
                                        style="border-radius: 12px; background: rgba(108, 117, 125, 0.1);">
                                        Back to Products
                                    </a>
                                    <button class="btn btn-primary btn-lg px-5 py-2 shadow-lg" type="submit"
                                        style="border-radius: 12px; background: linear-gradient(45deg, #667eea, #764ba2); border: none;">
                                        Update Product
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
        /* ...existing styles... */
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

        .form-label {
            color: #ea580c !important;
        }

        .current-image-preview img:hover {
            transform: scale(1.02);
            transition: all 0.3s ease;
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
        }
    </style>

    <!-- JavaScript -->
    <script>
        let existingImages = @json($currentImages ?? []);

        // Remove current image functionality
        function removeCurrentImage(button, imagePath) {
            if (confirm('Are you sure you want to remove this image?')) {
                // Remove from existing images array
                existingImages = existingImages.filter(path => path !== imagePath);

                // Update hidden input
                document.getElementById('existingImagesInput').value = JSON.stringify(existingImages);

                // Remove preview element
                button.closest('.col-md-3, .col-sm-4, .col-6').remove();
            }
        }

        // New image preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('productImages');
            const previewContainer = document.getElementById('imagePreviewContainer');
            let selectedFiles = [];

            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    handleFiles(e.target.files);
                });
            }

            function handleFiles(files) {
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
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
                    col.className = 'col-md-3 col-sm-4 col-6 mb-3';

                    col.innerHTML = `
                        <div class="image-preview">
                            <img src="${e.target.result}" alt="Preview" />
                            <button type="button" class="remove-image" onclick="removeNewImage(this, '${file.name}')">
                                <i class="fas fa-times"></i>
                            </button>
                            <small class="d-block text-center text-muted mt-1">${file.name}</small>
                        </div>
                    `;

                    previewContainer.appendChild(col);
                };
                reader.readAsDataURL(file);
            }

            window.removeNewImage = function(button, fileName) {
                selectedFiles = selectedFiles.filter(file => file.name !== fileName);
                button.closest('.col-md-3, .col-sm-4, .col-6').remove();
                updateFileInput();
            };

            function updateFileInput() {
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                imageInput.files = dt.files;
            }
        });
    </script>
@endsection
