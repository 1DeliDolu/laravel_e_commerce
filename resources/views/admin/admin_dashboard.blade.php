@extends('admin.main_design')

@section('dashboard')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-user-1"></i></div><strong>Total
                                Customers</strong>
                        </div>
                        <div class="number dashtext-1">{{ $totalCustomers }}</div>
                    </div>
                    <div class="progress progress-template">
                        <div class="progress-bar progress-bar-template dashbg-1" role="progressbar"
                            aria-valuenow="{{ $totalCustomers }}" aria-valuemin="0" aria-valuemax="100"
                            style="width: {{ min(($totalCustomers / 100) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-contract"></i></div><strong>Total
                                Products</strong>
                        </div>
                        <div class="number dashtext-2">{{ $totalProducts }}</div>
                    </div>
                    <div class="progress progress-template">
                        <div class="progress-bar progress-bar-template dashbg-2" role="progressbar"
                            aria-valuenow="{{ $totalProducts }}" aria-valuemin="0" aria-valuemax="100"
                            style="width: {{ min(($totalProducts / 50) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-paper-and-pencil"></i></div><strong>Total
                                Categories</strong>
                        </div>
                        <div class="number dashtext-3">{{ $totalCategories }}</div>
                    </div>
                    <div class="progress progress-template">
                        <div class="progress-bar progress-bar-template dashbg-3" role="progressbar"
                            aria-valuenow="{{ $totalCategories }}" aria-valuemin="0" aria-valuemax="100"
                            style="width: {{ min(($totalCategories / 20) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-writing-whiteboard"></i></div><strong>Total
                                Orders</strong>
                        </div>
                        <div class="number dashtext-4">{{ $totalOrders }}</div>
                    </div>
                    <div class="progress progress-template">
                        <div class="progress-bar progress-bar-template dashbg-4" role="progressbar"
                            aria-valuenow="{{ $totalOrders }}" aria-valuemin="0" aria-valuemax="100"
                            style="width: {{ min(($totalOrders / 100) * 100, 35) }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
