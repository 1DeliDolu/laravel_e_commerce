<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Receipt - {{ $order->order_number }}</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
                color: #333;
            }

            .header {
                text-align: center;
                margin-bottom: 30px;
                border-bottom: 2px solid #fd7e14;
                padding-bottom: 20px;
            }

            .company-name {
                font-size: 28px;
                font-weight: bold;
                color: #fd7e14;
                margin-bottom: 5px;
            }

            .receipt-title {
                font-size: 20px;
                color: #666;
                margin-bottom: 10px;
            }

            .order-info {
                display: flex;
                justify-content: space-between;
                margin-bottom: 30px;
            }

            .order-details,
            .customer-details {
                width: 48%;
            }

            .section-title {
                font-size: 16px;
                font-weight: bold;
                color: #fd7e14;
                margin-bottom: 10px;
                border-bottom: 1px solid #ddd;
                padding-bottom: 5px;
            }

            .info-item {
                margin-bottom: 5px;
            }

            .info-label {
                font-weight: bold;
                display: inline-block;
                width: 100px;
            }

            .items-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 30px;
            }

            .items-table th {
                background-color: #fd7e14;
                color: white;
                padding: 12px;
                text-align: left;
                font-weight: bold;
            }

            .items-table td {
                padding: 10px 12px;
                border-bottom: 1px solid #ddd;
            }

            .items-table tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            .text-right {
                text-align: right;
            }

            .text-center {
                text-align: center;
            }

            .totals {
                width: 300px;
                margin-left: auto;
                margin-top: 20px;
            }

            .total-row {
                display: flex;
                justify-content: space-between;
                padding: 5px 0;
                border-bottom: 1px solid #eee;
            }

            .total-row.final {
                font-weight: bold;
                font-size: 18px;
                color: #fd7e14;
                border-bottom: 2px solid #fd7e14;
                border-top: 2px solid #fd7e14;
                margin-top: 10px;
                padding-top: 10px;
            }

            .footer {
                margin-top: 40px;
                text-align: center;
                font-size: 12px;
                color: #666;
                border-top: 1px solid #ddd;
                padding-top: 20px;
            }

            .status-badge {
                display: inline-block;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: bold;
                text-transform: uppercase;
            }

            .status-pending {
                background-color: #fff3cd;
                color: #856404;
            }

            .status-processing {
                background-color: #d1ecf1;
                color: #0c5460;
            }

            .status-completed {
                background-color: #d4edda;
                color: #155724;
            }

            .status-cancelled {
                background-color: #f8d7da;
                color: #721c24;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <div class="company-name">GIFTOS</div>
            <div class="receipt-title">PURCHASE RECEIPT</div>
            <div style="font-size: 14px; color: #666;">
                Thank you for your purchase!
            </div>
        </div>

        <div class="order-info">
            <div class="order-details">
                <div class="section-title">Order Information</div>
                <div class="info-item">
                    <span class="info-label">Order #:</span>
                    <strong>{{ $order->order_number }}</strong>
                </div>
                <div class="info-item">
                    <span class="info-label">Date:</span>
                    {{ $order->order_date->format('M d, Y - H:i') }}
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="status-badge status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <div class="customer-details">
                <div class="section-title">Customer Information</div>
                <div class="info-item">
                    <span class="info-label">Name:</span>
                    {{ $order->customer_name }}
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    {{ $order->customer_email }}
                </div>
                <div class="info-item">
                    <span class="info-label">Phone:</span>
                    {{ $order->customer_phone }}
                </div>
                <div class="info-item">
                    <span class="info-label">Address:</span>
                    {{ $order->customer_address }}
                </div>
            </div>
        </div>

        <div class="section-title">Order Items</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->product_title }}</strong>
                            @if ($item->product && $item->product->category)
                                <br><small style="color: #666;">{{ $item->product->category->category }}</small>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">${{ number_format($item->product_price, 2) }}</td>
                        <td class="text-right">${{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="total-row">
                <span>Tax:</span>
                <span>${{ number_format($order->tax, 2) }}</span>
            </div>
            <div class="total-row">
                <span>Shipping:</span>
                <span>
                    @if ($order->shipping == 0)
                        FREE
                    @else
                        ${{ number_format($order->shipping, 2) }}
                    @endif
                </span>
            </div>
            <div class="total-row final">
                <span>TOTAL:</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <div class="footer">
            <p><strong>Giftos - Premium Gift Shop</strong></p>
            <p>Thank you for choosing us for your gifting needs!</p>
            <p>For any questions, please contact us at support@giftos.com</p>
            <p style="margin-top: 15px; font-size: 10px;">
                This is an electronically generated receipt.
                Generated on {{ now()->format('M d, Y - H:i:s') }}
            </p>
        </div>
    </body>

</html>
