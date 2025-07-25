<!DOCTYPE html>
<html>

    <head>
        <!-- Basic -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- Site Metas -->
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link type="image/x-icon" href="front_end/images/favicon.png" rel="shortcut icon">

        <title>
            Giftos
        </title>

        <!-- slider stylesheet -->
        <link type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
            rel="stylesheet" />

        <!-- bootstrap core css -->
        <link type="text/css" href="front_end/css/bootstrap.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="front_end/css/style.css" rel="stylesheet" />
        <!-- responsive style -->
        <link href="front_end/css/responsive.css" rel="stylesheet" />

        <!-- Custom Product Hover Effects -->
        <style>
            .product-card {
                transition: all 0.3s ease;
                cursor: pointer;
                position: relative;
                overflow: hidden;
            }

            .product-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }

            .product-card .img-box {
                overflow: hidden;
            }

            .product-card .img-box img {
                transition: transform 0.3s ease;
            }

            .product-card:hover .img-box img {
                transform: scale(1.05);
            }

            .product-card .detail-box {
                transition: all 0.3s ease;
            }

            .product-card:hover .detail-box {
                background: #f8f9fa;
            }

            .category-badge {
                font-size: 0.75rem;
                padding: 2px 8px;
                border-radius: 10px;
                margin-top: 5px;
                display: inline-block;
            }

            .cart-container {
                position: relative;
                display: inline-block;
                margin-right: 15px;
            }

            .cart-badge {
                position: absolute;
                top: -8px;
                right: -8px;
                background: #dc3545 !important;
                color: white !important;
                border-radius: 50%;
                padding: 2px 6px;
                font-size: 0.75rem;
                font-weight: bold;
                min-width: 18px;
                height: 18px;
                display: flex;
                align-items: center;
                justify-content: center;
                line-height: 1;
            }

            .cart-badge.show {
                display: flex !important;
            }
        </style>
    </head>

    <body>
        <div class="hero_area">
            <!-- header section strats -->
            <header class="header_section">
                <nav class="navbar navbar-expand-lg custom_nav-container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <span>
                            Giftos
                        </span>
                    </a>
                    <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent"
                        type="button" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class=""></span>
                    </button>

                    <div class="navbar-collapse collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ url('/') }}">Home <span
                                        class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="shop.html">
                                    Shop
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="why.html">
                                    Why Us
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="testimonial.html">
                                    Testimonial
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact.html">Contact Us</a>
                            </li>
                        </ul>
                        <div class="user_option">
                            @if (Auth::guard('customer')->check())
                                <!-- Customer logged in -->
                                <a class="btn nav_search-btn" href="{{ route('customer.dashboard') }}">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span>My Account</span>
                                </a>
                                <a class="btn nav_search-btn" href="#"
                                    onclick="event.preventDefault(); document.getElementById('customer-logout-form').submit();">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="customer-logout-form" style="display: none;"
                                    action="{{ route('customer.logout') }}" method="POST">
                                    @csrf
                                </form>
                            @elseif (Auth::check() && Auth::user()->user_type === 'admin')
                                <!-- Admin logged in -->
                                <a class="btn nav_search-btn" href="{{ route('admin.dashboard') }}">
                                    <i class="fa fa-tachometer-alt" aria-hidden="true"></i>
                                    <span>Admin Dashboard</span>
                                </a>
                                <a class="btn nav_search-btn" href="#"
                                    onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="admin-logout-form" style="display: none;" action="{{ route('logout') }}"
                                    method="POST">
                                    @csrf
                                </form>
                            @else
                                <!-- Not logged in -->
                                <a class="btn nav_search-btn" href="{{ route('customer.login') }}">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span>Login</span>
                                </a>
                                <a class="btn nav_search-btn" href="{{ route('customer.register') }}">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                    <span>Register</span>
                                </a>
                            @endif
                            <div class="cart-container position-relative">
                                <a id="cart-link" href="{{ route('cart.view') }}">
                                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                    <span class="cart-badge bg-danger text-white" id="cart-count"
                                        style="display: none;">0</span>
                                </a>
                            </div>
                            <form class="form-inline">
                                <button class="btn nav_search-btn" type="submit">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>
            </header>
            <!-- end header section -->
            <!-- slider section -->

            <section class="slider_section">
                <div class="slider_container">
                    <div class="carousel slide" id="carouselExampleIndicators" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="detail-box">
                                                <h1>
                                                    Welcome To Our <br>
                                                    Gift Shop
                                                </h1>
                                                <p>
                                                    Sequi perspiciatis nulla reiciendis, rem, tenetur impedit, eveniet
                                                    non
                                                    necessitatibus error distinctio mollitia suscipit. Nostrum fugit
                                                    doloribus consequatur distinctio esse, possimus maiores aliquid
                                                    repellat
                                                    beatae cum, perspiciatis enim, accusantium perferendis.
                                                </p>
                                                <a href="">
                                                    Contact Us
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="img-box">
                                                <img src="front_end/images/image3.jpeg" alt=""
                                                    style="width:600px" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </section>

            <!-- end slider section -->
        </div>
        <!-- end hero area -->

        <!-- shop section -->

        <section class="shop_section layout_padding">
            <div class="container">
                <div class="heading_container heading_center">
                    <h2>
                        Latest Products
                    </h2>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="box">
                            <a href="">
                                <div class="img-box">
                                    <img src="front_end/images/p1.png" alt="">
                                </div>
                                <div class="detail-box">
                                    <h6>
                                        Ring
                                    </h6>
                                    <h6>
                                        Price
                                        <span>
                                            $200
                                        </span>
                                    </h6>
                                </div>
                                <div class="new">
                                    <span>
                                        New
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="box">
                            <a href="">
                                <div class="img-box">
                                    <img src="front_end/images/p2.png" alt="">
                                </div>
                                <div class="detail-box">
                                    <h6>
                                        Watch
                                    </h6>
                                    <h6>
                                        Price
                                        <span>
                                            $300
                                        </span>
                                    </h6>
                                </div>
                                <div class="new">
                                    <span>
                                        New
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="box">
                            <a href="">
                                <div class="img-box">
                                    <img src="front_end/images/p3.png" alt="">
                                </div>
                                <div class="detail-box">
                                    <h6>
                                        Teddy Bear
                                    </h6>
                                    <h6>
                                        Price
                                        <span>
                                            $110
                                        </span>
                                    </h6>
                                </div>
                                <div class="new">
                                    <span>
                                        New
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="box">
                            <a href="">
                                <div class="img-box">
                                    <img src="front_end/images/p4.png" alt="">
                                </div>
                                <div class="detail-box">
                                    <h6>
                                        Flower Bouquet
                                    </h6>
                                    <h6>
                                        Price
                                        <span>
                                            $45
                                        </span>
                                    </h6>
                                </div>
                                <div class="new">
                                    <span>
                                        New
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="box">
                            <a href="">
                                <div class="img-box">
                                    <img src="front_end/images/p5.png" alt="">
                                </div>
                                <div class="detail-box">
                                    <h6>
                                        Teddy Bear
                                    </h6>
                                    <h6>
                                        Price
                                        <span>
                                            $95
                                        </span>
                                    </h6>
                                </div>
                                <div class="new">
                                    <span>
                                        New
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="box">
                            <a href="">
                                <div class="img-box">
                                    <img src="front_end/images/p6.png" alt="">
                                </div>
                                <div class="detail-box">
                                    <h6>
                                        Flower Bouquet
                                    </h6>
                                    <h6>
                                        Price
                                        <span>
                                            $70
                                        </span>
                                    </h6>
                                </div>
                                <div class="new">
                                    <span>
                                        New
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="box">
                            <a href="">
                                <div class="img-box">
                                    <img src="front_end/images/p7.png" alt="">
                                </div>
                                <div class="detail-box">
                                    <h6>
                                        Watch
                                    </h6>
                                    <h6>
                                        Price
                                        <span>
                                            $400
                                        </span>
                                    </h6>
                                </div>
                                <div class="new">
                                    <span>
                                        New
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="box">
                            <a href="">
                                <div class="img-box">
                                    <img src="front_end/images/p8.png" alt="">
                                </div>
                                <div class="detail-box">
                                    <h6>
                                        Ring
                                    </h6>
                                    <h6>
                                        Price
                                        <span>
                                            $450
                                        </span>
                                    </h6>
                                </div>
                                <div class="new">
                                    <span>
                                        New
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="btn-box">
                    <a href="">
                        View All Products
                    </a>
                </div>
            </div>
        </section>

        <!-- end shop section -->

        <!-- Dynamic Products Section from Database -->
        <section class="product_section layout_padding">
            <div class="container">
                <div class="heading_container heading_center">
                    <h2>
                        Our <span>products</span>
                    </h2>
                </div>
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="box product-card"
                                onclick="window.location.href='{{ route('product.detail', $product->id) }}'">
                                <div class="option_container">
                                    <div class="options">
                                        <a class="option1" href="{{ route('product.detail', $product->id) }}">
                                            View Details
                                        </a>
                                        <a class="option2" href="{{ route('product.detail', $product->id) }}">
                                            Buy Now
                                        </a>
                                    </div>
                                </div>
                                <div class="img-box">
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
                                        <img src="{{ asset($images[0]) }}" alt="{{ $product->product_title }}"
                                            style="height: 200px; object-fit: cover; width: 100%;" />
                                    @else
                                        <img src="front_end/images/p1.png" alt="{{ $product->product_title }}"
                                            style="height: 200px; object-fit: cover; width: 100%;" />
                                    @endif
                                </div>
                                <div class="detail-box">
                                    <h5 style="height: 50px; overflow: hidden;">
                                        {{ Str::limit($product->product_title, 40) }}
                                    </h5>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="text-primary fw-bold">
                                            ${{ number_format($product->product_price, 2) }}
                                        </h6>
                                        @if ($product->product_quantity > 0)
                                            <small class="badge bg-success">Stock:
                                                {{ $product->product_quantity }}</small>
                                        @else
                                            <small class="badge bg-danger">Out of Stock</small>
                                        @endif
                                    </div>
                                    <small class="category-badge bg-warning text-dark">
                                        <i class="fa fa-tag"></i> {{ $product->category->category ?? 'No Category' }}
                                    </small>
                                    <p class="mt-2" style="font-size: 0.85rem; height: 40px; overflow: hidden;">
                                        {{ Str::limit($product->product_description, 80) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center">
                            <div class="no-products">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">No Products Available</h4>
                                <p class="text-muted">Admin can add products from the admin panel!</p>
                                @if (Auth::check() && Auth::user()->user_type === 'admin')
                                    <a class="btn btn-primary" href="{{ route('add_product') }}">
                                        <i class="fas fa-plus me-1"></i>Add Products
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforelse
                </div>
                @if ($products->count() > 0)
                    <div class="btn-box">
                        <a href="#" onclick="showAllProducts()">
                            View All Products
                        </a>
                    </div>
                @endif
            </div>
        </section>

        <script>
            function showAllProducts() {
                // Future: Redirect to products page
                alert('Products page will be implemented soon!');
            }
        </script>

        <!-- contact section -->

        <section class="contact_section">
            <div class="container px-0">
                <div class="heading_container">
                    <h2 class="">
                        Contact Us
                    </h2>
                </div>
            </div>
            <div class="container-bg container">
                <div class="row">
                    <div class="col-lg-7 col-md-6 px-0">
                        <div class="map_container">
                            <div class="map-responsive">
                                <iframe
                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Eiffel+Tower+Paris+France"
                                    style="border:0; width: 100%; height:100%" width="600" height="300"
                                    frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5 px-0">
                        <form action="#">
                            <div>
                                <input type="text" placeholder="Name" />
                            </div>
                            <div>
                                <input type="email" placeholder="Email" />
                            </div>
                            <div>
                                <input type="text" placeholder="Phone" />
                            </div>
                            <div>
                                <input class="message-box" type="text" placeholder="Message" />
                            </div>
                            <div class="d-flex">
                                <button>
                                    SEND
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <br><br><br>

        <!-- end contact section -->

        <!-- info section -->

        <section class="info_section layout_padding2-top">
            <div class="social_container">
                <div class="social_box">
                    <a href="">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </a>
                    <a href="">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </a>
                    <a href="">
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="">
                        <i class="fa fa-youtube" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="info_container">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <h6>
                                ABOUT US
                            </h6>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit
                                amet,
                                consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
                            </p>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="info_form">
                                <h5>
                                    Newsletter
                                </h5>
                                <form action="#">
                                    <input type="email" placeholder="Enter your email">
                                    <button>
                                        Subscribe
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <h6>
                                NEED HELP
                            </h6>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit
                                amet,
                                consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
                            </p>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <h6>
                                CONTACT US
                            </h6>
                            <div class="info_link-box">
                                <a href="">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <span> Gb road 123 london Uk </span>
                                </a>
                                <a href="">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                    <span>+01 12345678901</span>
                                </a>
                                <a href="">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    <span> demo@gmail.com</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer section -->
            <footer class="footer_section">
                <div class="container">
                    <p>
                        &copy; <span id="displayYear"></span> All Rights Reserved By
                        <a href="https://html.design/">Web Tech Knowledge</a>
                    </p>
                </div>
            </footer>
            <!-- footer section -->

        </section>

        <!-- end info section -->

        <script src="front_end/js/jquery-3.4.1.min.js"></script>
        <script src="front_end/js/bootstrap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script src="front_end/js/custom.js"></script>

        <!-- Cart Functionality Scripts -->
        <script>
            $(document).ready(function() {
                // Set up CSRF token for AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Load cart count on page load
                updateCartCount();
            });

            function updateCartCount() {
                $.get('/cart/count', function(data) {
                    if (data.count > 0) {
                        $('#cart-count').text(data.count).show();
                    } else {
                        $('#cart-count').hide();
                    }
                }).fail(function() {
                    console.error('Failed to load cart count');
                });
            }

            function addToCart(productId, quantity = 1) {
                // Show loading state
                const originalText = event.target.innerHTML;
                event.target.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Adding...';
                event.target.disabled = true;

                $.ajax({
                    url: '/cart/add',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            updateCartCount();
                            showToast('Product added to cart!', 'success');
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
                        event.target.innerHTML = originalText;
                        event.target.disabled = false;
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
