@extends('backend.layouts.master')
@push('title')
    Dashboard
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div class="page-title">
                        <h4 class="mb-0 font-size-18">Dashboard</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Welcome to Agroxa Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content-wrapper">
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary mini-stat position-relative">
                        <div class="card-body">
                            <div class="mini-stat-desc">
                                <h5 class="text-uppercase verti-label font-size-16 text-white-50">Orders
                                </h5>
                                <div class="text-white">
                                    <h5 class="text-uppercase font-size-16 text-white-50">Orders</h5>
                                    <h3 class="mb-3 text-white">1,587</h3>
                                    <div class="">
                                        <span class="badge bg-light text-info"> +11% </span> <span class="ms-2">From
                                            previous period</span>
                                    </div>
                                </div>
                                <div class="mini-stat-icon">
                                    <i class="mdi mdi-cube-outline display-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary mini-stat position-relative">
                        <div class="card-body">
                            <div class="mini-stat-desc">
                                <h5 class="text-uppercase verti-label font-size-16 text-white-50">Revenue
                                </h5>
                                <div class="text-white">
                                    <h5 class="text-uppercase font-size-16 text-white-50">Revenue</h5>
                                    <h3 class="mb-3 text-white">$46,785</h3>
                                    <div class="">
                                        <span class="badge bg-light text-danger"> -29% </span> <span class="ms-2">From
                                            previous period</span>
                                    </div>
                                </div>
                                <div class="mini-stat-icon">
                                    <i class="mdi mdi-buffer display-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary mini-stat position-relative">
                        <div class="card-body">
                            <div class="mini-stat-desc">
                                <h5 class="text-uppercase verti-label font-size-16 text-white-50">Av. Price
                                </h5>
                                <div class="text-white">
                                    <h5 class="text-uppercase font-size-16 text-white-50">Average Price
                                    </h5>
                                    <h3 class="mb-3 text-white">15.9</h3>
                                    <div class="">
                                        <span class="badge bg-light text-primary"> 0% </span> <span class="ms-2">From
                                            previous period</span>
                                    </div>
                                </div>
                                <div class="mini-stat-icon">
                                    <i class="mdi mdi-tag-text-outline display-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary mini-stat position-relative">
                        <div class="card-body">
                            <div class="mini-stat-desc">
                                <h5 class="text-uppercase verti-label font-size-16 text-white-50">Pr. Sold
                                </h5>
                                <div class="text-white">
                                    <h5 class="text-uppercase font-size-16 text-white-50">Product Sold
                                    </h5>
                                    <h3 class="mb-3 text-white">1890</h3>
                                    <div class="">
                                        <span class="badge bg-light text-info"> +89% </span> <span class="ms-2">From
                                            previous period</span>
                                    </div>
                                </div>
                                <div class="mini-stat-icon">
                                    <i class="mdi mdi-briefcase-check display-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
