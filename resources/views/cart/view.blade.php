<!DOCTYPE html>
<html>

    <head>
        <!-- Basic -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link type="image/x-icon" href="{{ asset('front_end/images/favicon.png') }}" rel="shortcut icon">

        <title>Shopping Cart - Giftos</title>

        <!-- bootstrap core css -->
        <link type="text/css" href="{{ asset('front_end/css/bootstrap.css') }}" rel="stylesheet" />
        <!-- Custom styles for this template -->
        <link href="{{ asset('front_end/css/style.css') }}" rel="stylesheet" />
        <!-- responsive style -->
        <link href="{{ asset('front_end/css/responsive.css') }}" rel="stylesheet" />

        <style>
            .cart-container-page {
                padding: 60px 0;
                background: #f8f9fa;
                min-height: 80vh;
            }

            .cart-header {
                background: white;
                padding: 20px 0;
                border-bottom: 1px solid #eee;
                margin-bottom: 30px;
            }

            .cart-item {
                background: white;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .cart-item-image {
                width: 100px;
                height: 100px;
                object-fit: cover;
                border-radius: 8px;
            }

            .quantity-controls {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .quantity-btn {
                background: #fd7e14;
                color: white;
                border: none;
                width: 30px;
                height: 30px;
                border-radius: 5px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .quantity-input {
                width: 60px;
                text-align: center;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 5px;
            }

            .cart-summary {
                background: white;
                border-radius: 10px;
                padding: 30px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                position: sticky;
                top: 20px;
            }

            .btn-checkout {
                background: #fd7e14;
                color: white;
                border: none;
                padding: 15px 30px;
                border-radius: 10px;
                font-size: 1.1rem;
                font-weight: bold;
                width: 100%;
                transition: all 0.3s ease;
            }

            .btn-checkout:hover {
                background: #e96b07;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(253, 126, 20, 0.3);
            }

            .empty-cart {
                text-align: center;
                padding: 60px 20px;
                background: white;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .remove-btn {
                background: #dc3545;
                color: white;
                border: none;
                padding: 5px 10px;
                border-radius: 5px;
                font-size: 0.8rem;
            }

            .remove-btn:hover {
                background: #c82333;
            }

            /* Checkout Modal Styles */
            .alert-sm {
                padding: 8px 12px;
                font-size: 0.875rem;
            }

            .form-control:focus {
                border-color: #fd7e14;
                box-shadow: 0 0 0 0.2rem rgba(253, 126, 20, 0.25);
            }

            .form-control::placeholder {
                color: #6c757d;
                opacity: 0.7;
            }

            #customer-data-note {
                border-left: 4px solid #17a2b8;
                background-color: #f8f9fa;
                border-color: #b8daff;
            }

            .checkout-form-container {
                max-height: 70vh;
                overflow-y: auto;
            }
        </style>
    </head>

    <body>
        <!-- Cart Header -->
        <div class="cart-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="mb-0">
                            <i class="fa fa-shopping-cart text-primary me-2"></i>
                            Shopping Cart
                        </h2>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-outline-primary" href="{{ url('/') }}">
                            <i class="fa fa-arrow-left me-1"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Content -->
        <section class="cart-container-page">
            <div class="container">
                @if ($cartItems->count() > 0)
                    <div class="row">
                        <!-- Cart Items -->
                        <div class="col-lg-8">
                            @foreach ($cartItems as $item)
                                <div class="cart-item" id="cart-item-{{ $item->id }}">
                                    <div class="row align-items-center">
                                        <!-- Product Image -->
                                        <div class="col-md-2">
                                            @php
                                                $images = $item->product->product_images;
                                                if (is_string($images)) {
                                                    $images = json_decode($images, true) ?? [];
                                                }
                                                if (!is_array($images)) {
                                                    $images = [];
                                                }
                                            @endphp

                                            @if (!empty($images) && count($images) > 0)
                                                <img class="cart-item-image" src="{{ asset($images[0]) }}"
                                                    alt="{{ $item->product->product_title }}">
                                            @else
                                                <img class="cart-item-image"
                                                    src="{{ asset('front_end/images/p1.png') }}"
                                                    alt="{{ $item->product->product_title }}">
                                            @endif
                                        </div>

                                        <!-- Product Info -->
                                        <div class="col-md-4">
                                            <h5 class="mb-1">{{ $item->product->product_title }}</h5>
                                            <p class="text-muted mb-1">
                                                <small><i class="fa fa-tag"></i>
                                                    {{ $item->product->category->category ?? 'No Category' }}</small>
                                            </p>
                                            <p class="text-muted mb-0">
                                                <small>Stock: {{ $item->product->product_quantity }} available</small>
                                            </p>
                                        </div>

                                        <!-- Price -->
                                        <div class="col-md-2 text-center">
                                            <strong>${{ number_format($item->price, 2) }}</strong>
                                        </div>

                                        <!-- Quantity Controls -->
                                        <div class="col-md-2">
                                            <div class="quantity-controls">
                                                <button class="quantity-btn"
                                                    onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})">-</button>
                                                <input class="quantity-input" type="number"
                                                    value="{{ $item->quantity }}" min="1"
                                                    max="{{ $item->product->product_quantity }}"
                                                    onchange="updateQuantity({{ $item->id }}, this.value)">
                                                <button class="quantity-btn"
                                                    onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">+</button>
                                            </div>
                                        </div>

                                        <!-- Total & Remove -->
                                        <div class="col-md-2 text-center">
                                            <div class="mb-2">
                                                <strong
                                                    id="item-total-{{ $item->id }}">${{ number_format($item->quantity * $item->price, 2) }}</strong>
                                            </div>
                                            <button class="remove-btn" onclick="removeItem({{ $item->id }})">
                                                <i class="fa fa-trash"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Cart Summary -->
                        <div class="col-lg-4">
                            <div class="cart-summary">
                                <h4 class="mb-4">Order Summary</h4>

                                <div class="d-flex justify-content-between mb-3">
                                    <span>Subtotal ({{ $cartItems->sum('quantity') }} items):</span>
                                    <strong id="cart-subtotal">${{ number_format($totalAmount, 2) }}</strong>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span>Shipping:</span>
                                    <span>Free</span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span>Tax:</span>
                                    <span>$0.00</span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between mb-4">
                                    <h5>Total:</h5>
                                    <h5 id="cart-total">${{ number_format($totalAmount, 2) }}</h5>
                                </div>

                                <button class="btn-checkout" onclick="proceedToCheckout()">
                                    <i class="fa fa-credit-card me-1"></i>
                                    Proceed to Checkout
                                </button>

                                <div class="mt-3 text-center">
                                    <small class="text-muted">
                                        <i class="fa fa-lock"></i> Secure checkout with SSL encryption
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Modal -->
                    <div class="modal fade" id="checkoutModal" aria-labelledby="checkoutModalLabel" aria-hidden="true"
                        tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="checkoutModalLabel">
                                        <i class="fa fa-credit-card me-2"></i>Checkout
                                    </h5>
                                    <button class="btn-close" data-bs-dismiss="modal" type="button"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body checkout-form-container">
                                    <form id="checkoutForm">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="mb-3">Customer Information</h6>

                                                <!-- Customer data pre-filled notification -->
                                                <div class="alert alert-info alert-sm mb-3" id="customer-data-note"
                                                    style="display: none;">
                                                    <i class="fa fa-info-circle me-1"></i>
                                                    <small>Information pre-filled from your account. You can modify if
                                                        needed.</small>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="customer_name">Full Name *</label>
                                                    <input class="form-control" id="customer_name"
                                                        name="customer_name" type="text" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="customer_email">Email *</label>
                                                    <input class="form-control" id="customer_email"
                                                        name="customer_email" type="email" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="customer_phone">Phone *</label>
                                                    <input class="form-control" id="customer_phone"
                                                        name="customer_phone" type="tel" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="customer_address">Address *</label>
                                                    <textarea class="form-control" id="customer_address" name="customer_address" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="mb-3">Order Summary</h6>
                                                <div id="checkout-summary">
                                                    <!-- Summary will be loaded here -->
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal"
                                        type="button">Cancel</button>
                                    <button class="btn btn-primary" type="button" onclick="submitOrder()">
                                        <i class="fa fa-check me-1"></i>Place Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty Cart -->
                    <div class="empty-cart">
                        <i class="fa fa-shopping-cart fa-5x text-muted mb-4"></i>
                        <h3 class="text-muted mb-3">Your Cart is Empty</h3>
                        <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                        <a class="btn btn-primary btn-lg" href="{{ url('/') }}">
                            <i class="fa fa-shopping-bag me-1"></i>Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </section>

        <!-- Scripts -->
        <script src="{{ asset('front_end/js/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ asset('front_end/js/bootstrap.js') }}"></script>

        <script>
            // Set up CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function updateQuantity(cartId, newQuantity) {
                if (newQuantity < 1) return;

                $.ajax({
                    url: '/cart/update',
                    method: 'POST',
                    data: {
                        cart_id: cartId,
                        quantity: newQuantity
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update item total
                            $('#item-total-' + cartId).text('$' + parseFloat(response.total).toFixed(2));

                            // Recalculate totals
                            recalculateTotals();

                            showToast('Cart updated!', 'success');
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showToast(response.message || 'Error updating cart!', 'error');
                    }
                });
            }

            function removeItem(cartId) {
                if (confirm('Are you sure you want to remove this item?')) {
                    $.ajax({
                        url: '/cart/remove/' + cartId,
                        method: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                $('#cart-item-' + cartId).fadeOut(300, function() {
                                    $(this).remove();
                                    recalculateTotals();

                                    // Check if cart is empty
                                    if ($('.cart-item').length === 0) {
                                        location.reload();
                                    }
                                });
                                showToast('Item removed from cart!', 'success');
                            }
                        },
                        error: function() {
                            showToast('Error removing item!', 'error');
                        }
                    });
                }
            }

            function recalculateTotals() {
                let subtotal = 0;
                $('.cart-item').each(function() {
                    const itemTotalText = $(this).find('[id^="item-total-"]').text();
                    const itemTotal = parseFloat(itemTotalText.replace('$', ''));
                    subtotal += itemTotal;
                });

                $('#cart-subtotal').text('$' + subtotal.toFixed(2));
                $('#cart-total').text('$' + subtotal.toFixed(2));
            }

            function proceedToCheckout() {
                // Load checkout data
                $.ajax({
                    url: '/checkout/data',
                    method: 'GET',
                    success: function(response) {
                        // Fill customer data if logged in and available
                        if (response.customer_data && Object.keys(response.customer_data).length > 0) {
                            $('#customer_name').val(response.customer_data.name || '');
                            $('#customer_email').val(response.customer_data.email || '');
                            $('#customer_phone').val(response.customer_data.phone || '');
                            $('#customer_address').val(response.customer_data.address || '');

                            // Show a note that data is pre-filled from account
                            if (response.customer_data.name) {
                                $('#customer-data-note').show();
                            }
                        }

                        // Fill checkout summary
                        let summaryHtml = '';
                        response.cart_items.forEach(function(item) {
                            summaryHtml += `
                                <div class="d-flex justify-content-between mb-2">
                                    <span>${item.product.product_title} x ${item.quantity}</span>
                                    <span>$${(item.quantity * item.price).toFixed(2)}</span>
                                </div>
                            `;
                        });
                        summaryHtml += `
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>$${response.subtotal.toFixed(2)}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>FREE</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax:</span>
                                <span>$0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong>$${response.total.toFixed(2)}</strong>
                            </div>
                        `;
                        $('#checkout-summary').html(summaryHtml);

                        // Show modal
                        var checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
                        checkoutModal.show();
                    },
                    error: function() {
                        showToast('Error loading checkout data!', 'error');
                    }
                });
            }

            function submitOrder() {
                const form = document.getElementById('checkoutForm');

                // Form validation
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const formData = new FormData(form);

                // Show loading state
                const submitBtn = event.target;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
                submitBtn.disabled = true;

                // Immediately hide modal and show processing message
                var checkoutModal = bootstrap.Modal.getInstance(document.getElementById('checkoutModal'));
                checkoutModal.hide();

                showToast('Processing your order...', 'info');

                $.ajax({
                    url: '/checkout/process',
                    method: 'POST',
                    data: {
                        customer_name: formData.get('customer_name'),
                        customer_email: formData.get('customer_email'),
                        customer_phone: formData.get('customer_phone'),
                        customer_address: formData.get('customer_address')
                    },
                    timeout: 15000, // 15 second timeout
                    success: function(response) {
                        if (response.success) {
                            // Show success message immediately
                            showToast('Order placed successfully! Generating receipt...', 'success');

                            // Generate PDF immediately
                            const receiptUrl = '/checkout/receipt/' + response.order_id;

                            // Create download link and trigger automatic download
                            const downloadLink = document.createElement('a');
                            downloadLink.href = receiptUrl;
                            downloadLink.download = 'receipt-' + response.order_number + '.pdf';
                            downloadLink.style.display = 'none';
                            document.body.appendChild(downloadLink);

                            // Trigger download
                            downloadLink.click();
                            document.body.removeChild(downloadLink);

                            // Also open in new window for printing
                            setTimeout(function() {
                                const printWindow = window.open(receiptUrl, '_blank');
                                if (printWindow) {
                                    printWindow.onload = function() {
                                        printWindow.focus();
                                        setTimeout(function() {
                                            printWindow.print();
                                        }, 100);
                                    };
                                }
                            }, 500);

                            // Show completion message
                            showToast('Order completed! Receipt downloaded and ready to print.', 'success');

                            // Refresh cart after short delay
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showToast(response.message || 'Order processing failed. Please try again.', 'error');

                        // Re-open modal on error
                        setTimeout(function() {
                            checkoutModal.show();
                        }, 1000);
                    },
                    complete: function() {
                        // Reset button state
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                });
            }

            function showToast(message, type = 'info') {
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

                setTimeout(() => {
                    toast.css({
                        opacity: 1,
                        transform: 'translateX(0)'
                    });
                }, 100);

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
