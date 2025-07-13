<!DOCTYPE html>
<html>

    <head>
        <!-- Basic -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- Site Metas -->
        <meta name="keywords" content="{{ $product->product_title }}" />
        <meta name="description" content="{{ $product->product_description }}" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link type="image/x-icon" href="{{ asset('front_end/images/favicon.png') }}" rel="shortcut icon">

        <title>{{ $product->product_title }} - Giftos</title>

        <!-- bootstrap core css -->
        <link type="text/css" href="{{ asset('front_end/css/bootstrap.css') }}" rel="stylesheet" />
        <!-- Custom styles for this template -->
        <link href="{{ asset('front_end/css/style.css') }}" rel="stylesheet" />
        <!-- responsive style -->
        <link href="{{ asset('front_end/css/responsive.css') }}" rel="stylesheet" />

        <style>
            .product-detail-container {
                padding: 60px 0;
                background: #f8f9fa;
            }

            .product-image-gallery {
                position: relative;
            }

            .main-image {
                width: 100%;
                height: 500px;
                object-fit: cover;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .thumbnail-images {
                display: flex;
                gap: 10px;
                margin-top: 15px;
                overflow-x: auto;
            }

            .thumbnail {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 5px;
                cursor: pointer;
                border: 2px solid transparent;
                transition: all 0.3s ease;
            }

            .thumbnail:hover,
            .thumbnail.active {
                border-color: #fd7e14;
            }

            .product-info {
                padding: 20px;
            }

            .product-title {
                font-size: 2rem;
                font-weight: bold;
                color: #333;
                margin-bottom: 10px;
            }

            .product-price {
                font-size: 2.5rem;
                font-weight: bold;
                color: #fd7e14;
                margin-bottom: 15px;
            }

            .product-category {
                background: #fd7e14;
                color: white;
                padding: 5px 15px;
                border-radius: 20px;
                font-size: 0.9rem;
                display: inline-block;
                margin-bottom: 20px;
            }

            .stock-info {
                padding: 15px;
                border-radius: 10px;
                margin-bottom: 20px;
            }

            .in-stock {
                background: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }

            .out-of-stock {
                background: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }

            .product-description {
                font-size: 1.1rem;
                line-height: 1.6;
                color: #666;
                margin-bottom: 30px;
            }

            .quantity-selector {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 20px;
            }

            .quantity-input {
                width: 80px;
                text-align: center;
                border: 2px solid #ddd;
                border-radius: 5px;
                padding: 10px;
            }

            .btn-cart {
                background: #fd7e14;
                color: white;
                border: none;
                padding: 15px 30px;
                border-radius: 10px;
                font-size: 1.1rem;
                font-weight: bold;
                transition: all 0.3s ease;
            }

            .btn-cart:hover {
                background: #e96b07;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(253, 126, 20, 0.3);
            }

            .related-products {
                margin-top: 60px;
            }

            .related-product-card {
                border: 1px solid #ddd;
                border-radius: 10px;
                overflow: hidden;
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .related-product-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            .breadcrumb-custom {
                background: white;
                padding: 15px 0;
                border-bottom: 1px solid #eee;
            }
        </style>
    </head>

    <body>
        <!-- Breadcrumb -->
        <div class="breadcrumb-custom">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/') }}#products">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->product_title }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Product Detail Section -->
        <section class="product-detail-container">
            <div class="container">
                <div class="row">
                    <!-- Product Images -->
                    <div class="col-lg-6 col-md-6">
                        <div class="product-image-gallery">
                            @php
                                $images = $product->product_images;
                                if (is_string($images)) {
                                    $images = json_decode($images, true) ?? [];
                                }
                                if (!is_array($images)) {
                                    $images = [];
                                }
                            @endphp

                            @if (!empty($images) && count($images) > 0)
                                <img class="main-image" id="mainImage" src="{{ asset($images[0]) }}"
                                    alt="{{ $product->product_title }}">

                                @if (count($images) > 1)
                                    <div class="thumbnail-images">
                                        @foreach ($images as $index => $image)
                                            <img class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                                                src="{{ asset($image) }}" alt="{{ $product->product_title }}"
                                                onclick="changeMainImage('{{ asset($image) }}', this)">
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                <img class="main-image" src="{{ asset('front_end/images/p1.png') }}"
                                    alt="{{ $product->product_title }}">
                            @endif
                        </div>
                    </div>

                    <!-- Product Information -->
                    <div class="col-lg-6 col-md-6">
                        <div class="product-info">
                            <h1 class="product-title">{{ $product->product_title }}</h1>

                            <div class="product-price">${{ number_format($product->product_price, 2) }}</div>

                            <span class="product-category">
                                <i class="fa fa-tag"></i> {{ $product->category->category ?? 'No Category' }}
                            </span>

                            <div class="stock-info {{ $product->product_quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                                @if ($product->product_quantity > 0)
                                    <i class="fa fa-check-circle"></i>
                                    <strong>In Stock</strong> - {{ $product->product_quantity }} items available
                                @else
                                    <i class="fa fa-times-circle"></i>
                                    <strong>Out of Stock</strong>
                                @endif
                            </div>

                            <div class="product-description">
                                {{ $product->product_description }}
                            </div>

                            @if ($product->product_quantity > 0)
                                <div class="quantity-selector">
                                    <label for="quantity"><strong>Quantity:</strong></label>
                                    <input class="quantity-input" id="quantity" type="number" value="1"
                                        min="1" max="{{ $product->product_quantity }}">
                                </div>

                                <button class="btn btn-cart" onclick="addToCart({{ $product->id }})">
                                    <i class="fa fa-shopping-cart"></i> Add to Cart
                                </button>
                            @else
                                <button class="btn btn-secondary" disabled>
                                    <i class="fa fa-times"></i> Out of Stock
                                </button>
                            @endif

                            <div class="mt-4">
                                <a class="btn btn-outline-secondary" href="{{ url('/') }}">
                                    <i class="fa fa-arrow-left"></i> Back to Products
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <section class="related-products">
                <div class="container">
                    <div class="heading_container heading_center">
                        <h2>Related <span>Products</span></h2>
                    </div>
                    <div class="row">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="related-product-card"
                                    onclick="window.location.href='{{ route('product.detail', $relatedProduct->id) }}'">
                                    @php
                                        $relatedImages = $relatedProduct->product_images;
                                        if (is_string($relatedImages)) {
                                            $relatedImages = json_decode($relatedImages, true) ?? [];
                                        }
                                        if (!is_array($relatedImages)) {
                                            $relatedImages = [];
                                        }
                                    @endphp

                                    <div class="img-box">
                                        @if (!empty($relatedImages) && count($relatedImages) > 0)
                                            <img src="{{ asset($relatedImages[0]) }}"
                                                alt="{{ $relatedProduct->product_title }}"
                                                style="width: 100%; height: 200px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('front_end/images/p1.png') }}"
                                                alt="{{ $relatedProduct->product_title }}"
                                                style="width: 100%; height: 200px; object-fit: cover;">
                                        @endif
                                    </div>
                                    <div class="detail-box p-3">
                                        <h6>{{ Str::limit($relatedProduct->product_title, 30) }}</h6>
                                        <h6 class="text-primary">
                                            ${{ number_format($relatedProduct->product_price, 2) }}</h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Scripts -->
        <script src="{{ asset('front_end/js/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ asset('front_end/js/bootstrap.js') }}"></script>

        <script>
            function changeMainImage(imageSrc, thumbnailElement) {
                document.getElementById('mainImage').src = imageSrc;

                // Remove active class from all thumbnails
                document.querySelectorAll('.thumbnail').forEach(thumb => {
                    thumb.classList.remove('active');
                });

                // Add active class to clicked thumbnail
                thumbnailElement.classList.add('active');
            }

            function addToCart(productId) {
                const quantity = document.getElementById('quantity').value;

                // Set up CSRF token
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Show loading state
                const button = event.target;
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Adding...';
                button.disabled = true;

                $.ajax({
                    url: '/cart/add',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast('Product added to cart!', 'success');
                            // Redirect to homepage to see cart count
                            setTimeout(() => {
                                window.location.href = '/';
                            }, 1500);
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showToast(response.message || 'Error adding to cart!', 'error');
                    },
                    complete: function() {
                        // Reset button state
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }
                });
            }

            function showToast(message, type = 'info') {
                // Create toast element
                const toast = $(`
                    <div class="toast-message toast-${type}" style="
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#6c757d'};
                        color: white;
                        padding: 15px 20px;
                        border-radius: 5px;
                        z-index: 9999;
                        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                        opacity: 0;
                        transform: translateX(100%);
                        transition: all 0.3s ease;
                    ">
                        <i class="fa fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'}-circle"></i>
                        ${message}
                    </div>
                `);

                $('body').append(toast);

                // Animate in
                setTimeout(() => {
                    toast.css({
                        opacity: 1,
                        transform: 'translateX(0)'
                    });
                }, 100);

                // Remove after 3 seconds
                setTimeout(() => {
                    toast.css({
                        opacity: 0,
                        transform: 'translateX(100%)'
                    });
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
        </script>
    </body>

</html>
