@extends('admin.main_design')

@section('view_product')
    @if (session('product_delete'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('product_delete') }}
            <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
        </div>
    @elseif (session('product_update'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('product_update') }}
            <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="border-radius: 15px;">
                    <div class="card-header d-flex justify-content-between align-items-center border-0 text-white"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                        <div>
                            <h3 class="card-title fw-bold mb-0">
                                <i class="fas fa-boxes me-2"></i>All Products
                            </h3>
                            <small class="opacity-75">View and manage all products in the system</small>
                        </div>
                        <a class="btn btn-light btn-sm shadow-sm" href="{{ route('add_product') }}">
                            Add New Product
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if ($products->count() > 0)
                            <div class="table-responsive">
                                <table class="table-hover mb-0 table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="ps-4">ID</th>
                                            <th>Product Title</th>
                                            <th>Images</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Category</th>
                                            <th>Created Date</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr style="vertical-align: middle;">
                                                <td class="fw-bold text-primary ps-4">{{ $product->id }}</td>
                                                <td class="fw-semibold">{{ $product->product_title }}</td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @php
                                                            $images = $product->product_images;
                                                            // If it's a string, decode it to array
if (is_string($images)) {
    $images = json_decode($images, true) ?? [];
}
// Ensure it's an array
                                                            if (!is_array($images)) {
                                                                $images = [];
                                                            }
                                                        @endphp

                                                        @if (!empty($images) && count($images) > 0)
                                                            @foreach (array_slice($images, 0, 3) as $imagePath)
                                                                <img class="product-thumbnail" src="{{ asset($imagePath) }}"
                                                                    alt="Product Image"
                                                                    style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px; border: 2px solid #fd7e14; cursor: pointer;"
                                                                    onclick="showImageModal('{{ asset($imagePath) }}', '{{ $product->product_title }}')">
                                                            @endforeach
                                                            @if (count($images) > 3)
                                                                <span
                                                                    class="badge bg-orange text-dark d-flex align-items-center justify-content-center"
                                                                    style="width: 40px; height: 40px; border-radius: 8px; font-size: 0.7rem;">
                                                                    +{{ count($images) - 3 }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            <div class="d-flex align-items-center justify-content-center"
                                                                style="width: 40px; height: 40px; background: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px;">
                                                                <i class="fas fa-image text-muted"
                                                                    style="font-size: 0.8rem;"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-muted">{{ Str::limit($product->product_description, 50) }}
                                                </td>
                                                <td>
                                                    <span class="badge">{{ $product->product_quantity }} pcs</span>
                                                </td>
                                                <td class="fw-bold text-success">
                                                    ${{ number_format($product->product_price, 2) }}</td>
                                                <td>
                                                    <span class="badge">{{ $product->category->category ?? 'N/A' }}</span>
                                                </td>
                                                <td class="text-muted">{{ $product->created_at->format('Y-m-d') }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a class="btn btn-sm btn-outline-warning border-0 shadow-sm"
                                                            href="{{ route('edit_product', $product->id) }}"
                                                            title="Edit">
                                                            Update
                                                        </a>
                                                        <form style="display: inline;"
                                                            action="{{ route('delete_product', $product->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-outline-danger border-0 shadow-sm"
                                                                type="submit" title="Delete"
                                                                onclick="return confirm('Are you sure you want to delete this product?')">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if ($products->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-3 px-4 pb-4">
                                    <div class="text-muted">
                                        <small>
                                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of
                                            {{ $products->total() }} results
                                        </small>
                                    </div>
                                    <div>
                                        {{ $products->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="py-5 text-center">
                                <div class="mb-4">
                                    <i class="fas fa-box-open text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                </div>
                                <h4 class="text-muted">No products found</h4>
                                <p class="text-muted mb-4">Start by adding your first product.</p>
                                <a class="btn btn-primary btn-lg shadow-sm" href="{{ route('add_product') }}"
                                    style="border-radius: 12px; background: linear-gradient(45deg, #667eea, #764ba2); border: none;">
                                    Add Product
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" aria-labelledby="imageModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center">
                    <img class="img-fluid" id="modalImage" src="" alt="Product Image"
                        style="max-height: 70vh; border-radius: 0 0 12px 12px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .alert {
            border-left: 4px solid;
            border-radius: 12px !important;
        }

        .alert-success {
            border-left-color: #28a745;
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.05));
        }

        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
            transition: background-color 0.3s ease;
        }

        .btn-outline-warning:hover {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.5em 0.75em;
        }

        .card {
            transition: all 0.3s ease;
        }

        .btn-group .btn {
            margin-right: 0.25rem;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        /* Product image thumbnails */
        .product-thumbnail {
            transition: all 0.3s ease;
        }

        .product-thumbnail:hover {
            transform: scale(1.1);
            border-color: #fd7e14 !important;
            box-shadow: 0 4px 8px rgba(253, 126, 20, 0.3);
        }

        .bg-orange {
            background-color: #fd7e14 !important;
        }

        /* Modal styling */
        .modal-content {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        /* Image preview container */
        .d-flex.flex-wrap.gap-1 {
            max-width: 120px;
        }

        /* Pagination styling */
        .pagination {
            margin: 0;
        }

        .pagination .page-link {
            color: #fd7e14;
            border: 1px solid #fed7aa;
            border-radius: 8px;
            margin: 0 2px;
            padding: 0.5rem 0.75rem;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            color: #fff;
            background-color: #fd7e14;
            border-color: #fd7e14;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(253, 126, 20, 0.3);
        }

        .pagination .page-item.active .page-link {
            background-color: #fd7e14;
            border-color: #fd7e14;
            color: #fff;
            box-shadow: 0 2px 4px rgba(253, 126, 20, 0.3);
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .pagination .page-link:focus {
            box-shadow: 0 0 0 0.2rem rgba(253, 126, 20, 0.25);
        }

        /* Pagination info text styling */
        .pagination-info {
            color: #6c757d;
            font-size: 0.875rem;
        }
    </style>

    <!-- JavaScript for Image Modal -->
    <script>
        function showImageModal(imageSrc, productTitle) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModalLabel').textContent = productTitle + ' - Image';

            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        }
    </script>
@endsection
