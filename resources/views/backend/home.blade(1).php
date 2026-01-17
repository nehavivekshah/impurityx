@extends('backend.layout')
@section('title','Dashboard - Impurity X')
@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css">
<!-- Link Styles -->
<link rel="stylesheet" href="{{ asset('/assets/backend/css/style.css') }}">
<style>
    :root {
        --bs-body-bg: #f8f9fa;
        --bs-border-radius: .5rem;
    }
    .card {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        border-radius: var(--bs-border-radius);
    }
    /* KPI Card Styles */
    .kpi-card {
        border-bottom-width: 4px;
        border-bottom-style: solid;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 1.5rem rgba(0, 0, 0, 0.08);
    }
    .kpi-card .card-body {
        padding: 1.5rem;
    }
    .kpi-card__title {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    .kpi-card__value {
        font-size: 2rem;
        font-weight: 700;
    }
    .kpi-card__value .bx {
        font-size: 1.5rem;
        vertical-align: middle;
    }
    .kpi-card__gauge {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-weight: 600;
        font-size: 0.9rem;
        color: #343a40;
        background: conic-gradient(var(--gauge-color, #6c757d) calc(var(--gauge-value) * 1%), #e9ecef calc(var(--gauge-value) * 1%));
    }
    /* KPI Card Border Colors */
    .border-bottom-primary {
        border-color: #0d6efd;
    }
    .border-bottom-danger {
        border-color: #dc3545;
    }
    .border-bottom-warning {
        border-color: #ffc107;
    }
    .border-bottom-success {
        border-color: #198754;
    }
    /* Chart Card Styles */
    .chart-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.25rem;
    }
    .chart-card-header .actions .btn {
        background-color: #ffc107;
        color: #000;
        border: none;
    }
    .chart-container {
        position: relative;
        height: 320px;
    }
    /* Income Chart Specifics */
    .income-chart-wrapper {
        position: relative;
        height: 220px;
        margin-bottom: 1rem;
    }
    .income-chart-center-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        pointer-events: none;
    }
    .income-chart-center-text .percent-label {
        font-size: 0.9rem;
        color: #6c757d;
    }
    .income-chart-center-text .percent-value {
        font-size: 2.25rem;
        font-weight: 700;
        line-height: 1;
    }
    .spendings-target {
        font-size: 0.9rem;
    }
    .spendings-target .progress {
        height: 0.5rem;
    }
    @media(min-width:768px) {
        .admin-dashboard-grid .col-xl-3 {
            width: 20%;
        }
        .admin-dashboard-grid .card .card-body {
            min-height: 130px;
        }
    }
</style>
@endsection
@section('content')
<section class="task__section">
    <div class="main-content">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center py-3 px-4 border-bottom bg-white shadow-sm mb-3">
            <h5 class="fw-bold mb-0 text-dark">Dashboard</h5>
            <div class="d-flex align-items-center gap-3">
                <!-- Notification Icon -->
                <div class="position-relative">
                    <a href="#" class="btn btn-light position-relative p-2 rounded-circle shadow-sm">
                        <i class="bx bx-bell fs-5 text-dark"></i>
                        <!--<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3+</span>-->
                    </a>
                </div>
                <!-- User Dropdown -->
                <div class="dropdown">
                    <a href="javascript:void(0)" class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2 position-relative" data-bs-toggle="dropdown">
                        <i class="bx bx-user fs-5"></i> {{ Auth::user()->first_name }}
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-white rounded-circle"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border right-menu">
                        <li><a class="dropdown-item" href="/admin/profile"><i class="bx bx-user me-2"></i> My Profile</a></li>
                        <li><a class="dropdown-item" href="/admin/reset-password"><i class="bx bx-reset me-2"></i> Reset Password</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="/admin/logout"><i class="bx bx-log-out me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row my-2 mt-4">
            <div class="col-md-12">
                <h2 class="fw-bold mb-0 text-dark">Admin Pending Tasks :</h2>
            </div>
        </div>
        <!-- KPI Cards Row -->
        <div class="row g-4 my-2 admin-dashboard-grid">
            @php
            $productActivePercent = $totalProducts > 0 ? round(($totalActiveProducts * 100) / $totalProducts) : 0;
            $productColor = match(true) {
            $productActivePercent > 75 => '#0d6efd', // Blue
            $productActivePercent > 50 => '#198754', // Green
            $productActivePercent > 25 => '#ffc107', // Yellow
            default => '#dc3545', // Red
            };
            $productBorderColor = match(true) {
            $productActivePercent > 75 => 'primary', // Blue
            $productActivePercent > 50 => 'success', // Green
            $productActivePercent > 25 => 'warning', // Yellow
            default => 'danger', // Red
            };
            $productGraphTextColor = match(true) {
            $productActivePercent > 50 => 'text-white', // Green
            default => 'text-dark', // Red
            };
            @endphp
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$productBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Bid Initiated, Pending with Admin</div>
                            <div class="kpi-card__value">+{{ $totalActiveProducts }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $productGraphTextColor }}" style="--gauge-value: {{ min($productActivePercent, 100) }}; --gauge-color: {{ $productColor }};">
                            {{ $productActivePercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            @php
            $postsPercent = $totalPosts > 0 ? round(($totalActivePosts * 100) / $totalPosts) : 0;
            $buyersColor = match(true) {
            $postsPercent > 75 => '#0d6efd', // Blue
            $postsPercent > 50 => '#198754', // Green
            $postsPercent > 25 => '#ffc107', // Yellow
            default => '#dc3545', // Red
            };
            $buyersBorderColor = match(true) {
            $postsPercent > 75 => 'primary', // Blue
            $postsPercent > 50 => 'success', // Green
            $postsPercent > 25 => 'warning', // Yellow
            default => 'danger', // Red
            };
            $buyersGraphTextColor = match(true) {
            $postsPercent > 50 => 'text-white', // Green
            default => 'text-dark', // Red
            };
            @endphp
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$buyersBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Bid Accepted, Pending With Admin</div>
                            <div class="kpi-card__value">+{{ $totalActivePosts }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $buyersGraphTextColor }}" style="--gauge-value: {{ min($postsPercent, 100) }}; --gauge-color: {{ $buyersColor }};">
                            {{ $postsPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            @php
            $buyersPercent = $totalBuyers > 0 ? round(($totalActiveBuyers * 100) / $totalBuyers) : 0;
            $buyersColor = match(true) {
            $buyersPercent > 75 => '#0d6efd', // Blue
            $buyersPercent > 50 => '#198754', // Green
            $buyersPercent > 25 => '#ffc107', // Yellow
            default => '#dc3545', // Red
            };
            $buyersBorderColor = match(true) {
            $buyersPercent > 75 => 'primary', // Blue
            $buyersPercent > 50 => 'success', // Green
            $buyersPercent > 25 => 'warning', // Yellow
            default => 'danger', // Red
            };
            $buyersGraphTextColor = match(true) {
            $buyersPercent > 50 => 'text-white', // Green
            default => 'text-dark', // Red
            };
            @endphp
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$buyersBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">New Buyer Regn Request</div>
                            <div class="kpi-card__value text-dark">{{ $totalActiveBuyers }}/{{ $totalBuyers }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $buyersGraphTextColor }}" style="--gauge-value: {{ min($buyersPercent, 100) }}; --gauge-color: {{ $buyersColor }};">
                            {{ $buyersPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            @php
            $sellersPercent = $totalSellers > 0 ? round(($totalActiveSellers * 100) / $totalSellers) : 0;
            $gaugeColor = match(true) {
            $sellersPercent > 75 => '#0d6efd', // blue
            $sellersPercent > 50 => '#198754', // green
            $sellersPercent > 25 => '#ffc107', // yellow
            default => '#dc3545', // red
            };
            $gaugeBorderColor = match(true) {
            $sellersPercent > 75 => 'primary', // Blue
            $sellersPercent > 50 => 'success', // Green
            $sellersPercent > 25 => 'warning', // Yellow
            default => 'danger', // Red
            };
            $gaugeGraphTextColor = match(true) {
            $sellersPercent > 50 => 'text-white', // Green
            default => 'text-dark', // Red
            };
            @endphp
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$gaugeBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">New Seller Regn Request</div>
                            <div class="kpi-card__value text-dark">{{ $totalActiveSellers }}/{{ $totalSellers }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $gaugeGraphTextColor }}" style="--gauge-value: {{ min($sellersPercent, 100) }}; --gauge-color: {{ $gaugeColor }};">
                            {{ $sellersPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$gaugeBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">New Inter Party Mail</div>
                            <div class="kpi-card__value text-dark">{{ $totalActiveSellers }}/{{ $totalSellers }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $gaugeGraphTextColor }}" style="--gauge-value: {{ min($sellersPercent, 100) }}; --gauge-color: {{ $gaugeColor }};">
                            {{ $sellersPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 my-2 admin-dashboard-grid"> 
            @php
            $postsPercent = $totalPosts > 0 ? round(($totalActivePosts * 100) / $totalPosts) : 0;
            $buyersColor = match(true) {
            $postsPercent > 75 => '#0d6efd', // Blue
            $postsPercent > 50 => '#198754', // Green
            $postsPercent > 25 => '#ffc107', // Yellow
            default => '#dc3545', // Red
            };
            $buyersBorderColor = match(true) {
            $postsPercent > 75 => 'primary', // Blue
            $postsPercent > 50 => 'success', // Green
            $postsPercent > 25 => 'warning', // Yellow
            default => 'danger', // Red
            };
            $buyersGraphTextColor = match(true) {
            $postsPercent > 50 => 'text-white', // Green
            default => 'text-dark', // Red
            };
            @endphp
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$buyersBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">New Products Request received</div>
                            <div class="kpi-card__value">+{{ $totalActivePosts }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $buyersGraphTextColor }}" style="--gauge-value: {{ min($postsPercent, 100) }}; --gauge-color: {{ $buyersColor }};">
                            {{ $postsPercent }}%
                        </div> -->
                    </div>
                </div>
            </div> 
        </div>
        <div class="row my-2 mt-4">
            <div class="col-md-12">
                <h2 class="fw-bold mb-0 text-dark">Bidding :</h2>
            </div>
        </div>
        <div class="row g-4 my-2 admin-dashboard-grid">
            <!--@php-->
            <!--$productActivePercent = $totalProducts > 0 ? round(($totalActiveProducts * 100) / $totalProducts) : 0;-->
            <!--$productColor = match(true) {-->
            <!--$productActivePercent > 75 => '#0d6efd', // Blue-->
            <!--$productActivePercent > 50 => '#198754', // Green-->
            <!--$productActivePercent > 25 => '#ffc107', // Yellow-->
            <!--default => '#dc3545', // Red-->
            <!--};-->
            <!--$productBorderColor = match(true) {-->
            <!--$productActivePercent > 75 => 'primary', // Blue-->
            <!--$productActivePercent > 50 => 'success', // Green-->
            <!--$productActivePercent > 25 => 'warning', // Yellow-->
            <!--default => 'danger', // Red-->
            <!--};-->
            <!--$productGraphTextColor = match(true) {-->
            <!--$productActivePercent > 50 => 'text-white', // Green-->
            <!--default => 'text-dark', // Red-->
            <!--};-->
            <!--@endphp-->
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$productBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Active Bids Count</div>
                            <div class="kpi-card__value">+{{ $totalActiveProducts }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $productGraphTextColor }}" style="--gauge-value: {{ min($productActivePercent, 100) }}; --gauge-color: {{ $productColor }};">
                            {{ $productActivePercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            <!--@php-->
            <!--$postsPercent = $totalPosts > 0 ? round(($totalActivePosts * 100) / $totalPosts) : 0;-->
            <!--$buyersColor = match(true) {-->
            <!--$postsPercent > 75 => '#0d6efd', // Blue-->
            <!--$postsPercent > 50 => '#198754', // Green-->
            <!--$postsPercent > 25 => '#ffc107', // Yellow-->
            <!--default => '#dc3545', // Red-->
            <!--};-->
            <!--$buyersBorderColor = match(true) {-->
            <!--$postsPercent > 75 => 'primary', // Blue-->
            <!--$postsPercent > 50 => 'success', // Green-->
            <!--$postsPercent > 25 => 'warning', // Yellow-->
            <!--default => 'danger', // Red-->
            <!--};-->
            <!--$buyersGraphTextColor = match(true) {-->
            <!--$postsPercent > 50 => 'text-white', // Green-->
            <!--default => 'text-dark', // Red-->
            <!--};-->
            <!--@endphp-->
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$buyersBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Non Active Bids Count</div>
                            <div class="kpi-card__value">+{{ $totalActivePosts }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $buyersGraphTextColor }}" style="--gauge-value: {{ min($postsPercent, 100) }}; --gauge-color: {{ $buyersColor }};">
                            {{ $postsPercent }}%
                        </div> -->
                    </div>
                </div>
            </div> 
            @php
            $buyersPercent = $totalBuyers > 0 ? round(($totalActiveBuyers * 100) / $totalBuyers) : 0;
            $buyersColor = match(true) {
            $buyersPercent > 75 => '#0d6efd', // Blue
            $buyersPercent > 50 => '#198754', // Green
            $buyersPercent > 25 => '#ffc107', // Yellow
            default => '#dc3545', // Red
            };
            $buyersBorderColor = match(true) {
            $buyersPercent > 75 => 'primary', // Blue
            $buyersPercent > 50 => 'success', // Green
            $buyersPercent > 25 => 'warning', // Yellow
            default => 'danger', // Red
            };
            $buyersGraphTextColor = match(true) {
            $buyersPercent > 50 => 'text-white', // Green
            default => 'text-dark', // Red
            };
            @endphp
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$buyersBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Active and Participated Bids Count</div>
                            <div class="kpi-card__value text-dark">{{ $totalActiveBuyers }}/{{ $totalBuyers }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $buyersGraphTextColor }}" style="--gauge-value: {{ min($buyersPercent, 100) }}; --gauge-color: {{ $buyersColor }};">
                            {{ $buyersPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            @php
            $sellersPercent = $totalSellers > 0 ? round(($totalActiveSellers * 100) / $totalSellers) : 0;
            $gaugeColor = match(true) {
            $sellersPercent > 75 => '#0d6efd', // blue
            $sellersPercent > 50 => '#198754', // green
            $sellersPercent > 25 => '#ffc107', // yellow
            default => '#dc3545', // red
            };
            $gaugeBorderColor = match(true) {
            $sellersPercent > 75 => 'primary', // Blue
            $sellersPercent > 50 => 'success', // Green
            $sellersPercent > 25 => 'warning', // Yellow
            default => 'danger', // Red
            };
            $gaugeGraphTextColor = match(true) {
            $sellersPercent > 50 => 'text-white', // Green
            default => 'text-dark', // Red
            };
            @endphp
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$gaugeBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Bids Closed, - pending with Customers</div>
                            <div class="kpi-card__value text-dark">{{ $totalActiveSellers }}/{{ $totalSellers }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $gaugeGraphTextColor }}" style="--gauge-value: {{ min($sellersPercent, 100) }}; --gauge-color: {{ $gaugeColor }};">
                            {{ $sellersPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$gaugeBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Buyer - Accepted, Pending with Admin</div>
                            <div class="kpi-card__value text-dark">{{ $totalActiveSellers }}/{{ $totalSellers }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $gaugeGraphTextColor }}" style="--gauge-value: {{ min($sellersPercent, 100) }}; --gauge-color: {{ $gaugeColor }};">
                            {{ $sellersPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 my-2 admin-dashboard-grid">
            @php
            $productActivePercent = $totalProducts > 0 ? round(($totalActiveProducts * 100) / $totalProducts) : 0;
            $productColor = match(true) {
            $productActivePercent > 75 => '#0d6efd', // Blue
            $productActivePercent > 50 => '#198754', // Green
            $productActivePercent > 25 => '#ffc107', // Yellow
            default => '#dc3545', // Red
            };
            $productBorderColor = match(true) {
            $productActivePercent > 75 => 'primary', // Blue
            $productActivePercent > 50 => 'success', // Green
            $productActivePercent > 25 => 'warning', // Yellow
            default => 'danger', // Red
            };
            $productGraphTextColor = match(true) {
            $productActivePercent > 50 => 'text-white', // Green
            default => 'text-dark', // Red
            };
            @endphp
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$productBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Bid Won Count</div>
                            <div class="kpi-card__value">+{{ $totalActiveProducts }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $productGraphTextColor }}" style="--gauge-value: {{ min($productActivePercent, 100) }}; --gauge-color: {{ $productColor }};">
                            {{ $productActivePercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            @php
            $postsPercent = $totalPosts > 0 ? round(($totalActivePosts * 100) / $totalPosts) : 0;
            $buyersColor = match(true) {
            $postsPercent > 75 => '#0d6efd', // Blue
            $postsPercent > 50 => '#198754', // Green
            $postsPercent > 25 => '#ffc107', // Yellow
            default => '#dc3545', // Red
            };
            $buyersBorderColor = match(true) {
            $postsPercent > 75 => 'primary', // Blue
            $postsPercent > 50 => 'success', // Green
            $postsPercent > 25 => 'warning', // Yellow
            default => 'danger', // Red
            };
            $buyersGraphTextColor = match(true) {
            $postsPercent > 50 => 'text-white', // Green
            default => 'text-dark', // Red
            };
            @endphp
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$buyersBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">No. of Buyers in Active Bid</div>
                            <div class="kpi-card__value">+{{ $totalActivePosts }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $buyersGraphTextColor }}" style="--gauge-value: {{ min($postsPercent, 100) }}; --gauge-color: {{ $buyersColor }};">
                            {{ $postsPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            @php
            $buyersPercent = $totalBuyers > 0 ? round(($totalActiveBuyers * 100) / $totalBuyers) : 0;
            $buyersColor = match(true) {
            $buyersPercent > 75 => '#0d6efd', // Blue
            $buyersPercent > 50 => '#198754', // Green
            $buyersPercent > 25 => '#ffc107', // Yellow
            default => '#dc3545', // Red
            };
            $buyersBorderColor = match(true) {
            $buyersPercent > 75 => 'primary', // Blue
            $buyersPercent > 50 => 'success', // Green
            $buyersPercent > 25 => 'warning', // Yellow
            default => 'danger', // Red
            };
            $buyersGraphTextColor = match(true) {
            $buyersPercent > 50 => 'text-white', // Green
            default => 'text-dark', // Red
            };
            @endphp
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$buyersBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">No. of Sellers in Active Bid</div>
                            <div class="kpi-card__value text-dark">{{ $totalActiveBuyers }}/{{ $totalBuyers }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $buyersGraphTextColor }}" style="--gauge-value: {{ min($buyersPercent, 100) }}; --gauge-color: {{ $buyersColor }};">
                            {{ $buyersPercent }}%
                        </div> -->
                    </div>
                </div>
            </div> 
        </div>
        <div class="row my-2 mt-4">
            <div class="col-md-12">
                <h2 class="fw-bold mb-0 text-dark">Orders :</h2>
            </div>
        </div>
        <div class="row g-4 my-2 admin-dashboard-grid">
            <!--@php-->
            <!--$productActivePercent = $totalProducts > 0 ? round(($totalActiveProducts * 100) / $totalProducts) : 0;-->
            <!--$productColor = match(true) {-->
            <!--$productActivePercent > 75 => '#0d6efd', // Blue-->
            <!--$productActivePercent > 50 => '#198754', // Green-->
            <!--$productActivePercent > 25 => '#ffc107', // Yellow-->
            <!--default => '#dc3545', // Red-->
            <!--};-->
            <!--$productBorderColor = match(true) {-->
            <!--$productActivePercent > 75 => 'primary', // Blue-->
            <!--$productActivePercent > 50 => 'success', // Green-->
            <!--$productActivePercent > 25 => 'warning', // Yellow-->
            <!--default => 'danger', // Red-->
            <!--};-->
            <!--$productGraphTextColor = match(true) {-->
            <!--$productActivePercent > 50 => 'text-white', // Green-->
            <!--default => 'text-dark', // Red-->
            <!--};-->
            <!--@endphp-->
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$productBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">WIP Order</div>
                            <div class="kpi-card__value">+{{ $totalActiveProducts }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $productGraphTextColor }}" style="--gauge-value: {{ min($productActivePercent, 100) }}; --gauge-color: {{ $productColor }};">
                            {{ $productActivePercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            <!--@php-->
            <!--$postsPercent = $totalPosts > 0 ? round(($totalActivePosts * 100) / $totalPosts) : 0;-->
            <!--$buyersColor = match(true) {-->
            <!--$postsPercent > 75 => '#0d6efd', // Blue-->
            <!--$postsPercent > 50 => '#198754', // Green-->
            <!--$postsPercent > 25 => '#ffc107', // Yellow-->
            <!--default => '#dc3545', // Red-->
            <!--};-->
            <!--$buyersBorderColor = match(true) {-->
            <!--$postsPercent > 75 => 'primary', // Blue-->
            <!--$postsPercent > 50 => 'success', // Green-->
            <!--$postsPercent > 25 => 'warning', // Yellow-->
            <!--default => 'danger', // Red-->
            <!--};-->
            <!--$buyersGraphTextColor = match(true) {-->
            <!--$postsPercent > 50 => 'text-white', // Green-->
            <!--default => 'text-dark', // Red-->
            <!--};-->
            <!--@endphp-->
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$buyersBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Active & Participated Ord Val (in Rs. Mn)</div>
                            <div class="kpi-card__value">+{{ $totalActivePosts }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $buyersGraphTextColor }}" style="--gauge-value: {{ min($postsPercent, 100) }}; --gauge-color: {{ $buyersColor }};">
                            {{ $postsPercent }}%
                        </div> -->
                    </div>
                </div>
            </div> 
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$gaugeBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Bid Won Count</div>
                            <div class="kpi-card__value text-dark">{{ $totalActiveSellers }}/{{ $totalSellers }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $gaugeGraphTextColor }}" style="--gauge-value: {{ min($sellersPercent, 100) }}; --gauge-color: {{ $gaugeColor }};">
                            {{ $sellersPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$gaugeBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Orders Completed</div>
                            <div class="kpi-card__value text-dark">{{ $totalActiveSellers }}/{{ $totalSellers }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $gaugeGraphTextColor }}" style="--gauge-value: {{ min($sellersPercent, 100) }}; --gauge-color: {{ $gaugeColor }};">
                            {{ $sellersPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 my-2 admin-dashboard-grid">
            <!--@php-->
            <!--$productActivePercent = $totalProducts > 0 ? round(($totalActiveProducts * 100) / $totalProducts) : 0;-->
            <!--$productColor = match(true) {-->
            <!--$productActivePercent > 75 => '#0d6efd', // Blue-->
            <!--$productActivePercent > 50 => '#198754', // Green-->
            <!--$productActivePercent > 25 => '#ffc107', // Yellow-->
            <!--default => '#dc3545', // Red-->
            <!--};-->
            <!--$productBorderColor = match(true) {-->
            <!--$productActivePercent > 75 => 'primary', // Blue-->
            <!--$productActivePercent > 50 => 'success', // Green-->
            <!--$productActivePercent > 25 => 'warning', // Yellow-->
            <!--default => 'danger', // Red-->
            <!--};-->
            <!--$productGraphTextColor = match(true) {-->
            <!--$productActivePercent > 50 => 'text-white', // Green-->
            <!--default => 'text-dark', // Red-->
            <!--};-->
            <!--@endphp-->
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$productBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Total Sellers Onboarded</div>
                            <div class="kpi-card__value">+{{ $totalActiveProducts }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $productGraphTextColor }}" style="--gauge-value: {{ min($productActivePercent, 100) }}; --gauge-color: {{ $productColor }};">
                            {{ $productActivePercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            <!--@php-->
            <!--$postsPercent = $totalPosts > 0 ? round(($totalActivePosts * 100) / $totalPosts) : 0;-->
            <!--$buyersColor = match(true) {-->
            <!--$postsPercent > 75 => '#0d6efd', // Blue-->
            <!--$postsPercent > 50 => '#198754', // Green-->
            <!--$postsPercent > 25 => '#ffc107', // Yellow-->
            <!--default => '#dc3545', // Red-->
            <!--};-->
            <!--$buyersBorderColor = match(true) {-->
            <!--$postsPercent > 75 => 'primary', // Blue-->
            <!--$postsPercent > 50 => 'success', // Green-->
            <!--$postsPercent > 25 => 'warning', // Yellow-->
            <!--default => 'danger', // Red-->
            <!--};-->
            <!--$buyersGraphTextColor = match(true) {-->
            <!--$postsPercent > 50 => 'text-white', // Green-->
            <!--default => 'text-dark', // Red-->
            <!--};-->
            <!--@endphp-->
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$buyersBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Total Sellers Onboarded</div>
                            <div class="kpi-card__value">+{{ $totalActivePosts }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $buyersGraphTextColor }}" style="--gauge-value: {{ min($postsPercent, 100) }}; --gauge-color: {{ $buyersColor }};">
                            {{ $postsPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>  
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$gaugeBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Total Buyers Onboarded</div>
                            <div class="kpi-card__value text-dark">{{ $totalActiveSellers }}/{{ $totalSellers }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $gaugeGraphTextColor }}" style="--gauge-value: {{ min($sellersPercent, 100) }}; --gauge-color: {{ $gaugeColor }};">
                            {{ $sellersPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$gaugeBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Active Buyers Count</div>
                            <div class="kpi-card__value text-dark">{{ $totalActiveSellers }}/{{ $totalSellers }}</div>
                        </div>
                        <!-- <div class="kpi-card__gauge {{ $gaugeGraphTextColor }}" style="--gauge-value: {{ min($sellersPercent, 100) }}; --gauge-color: {{ $gaugeColor }};">
                            {{ $sellersPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Charts Row --> 
         <div class="row my-2 mt-4">
            <div class="col-md-12">
                <h2 class="fw-bold mb-0 text-dark">Critical :</h2>
            </div>
        </div>
        <div class="row g-4 my-2 admin-dashboard-grid">
            <!--@php-->
            <!--$productActivePercent = $totalProducts > 0 ? round(($totalActiveProducts * 100) / $totalProducts) : 0;-->
            <!--$productColor = match(true) {-->
            <!--$productActivePercent > 75 => '#0d6efd', // Blue-->
            <!--$productActivePercent > 50 => '#198754', // Green-->
            <!--$productActivePercent > 25 => '#ffc107', // Yellow-->
            <!--default => '#dc3545', // Red-->
            <!--};-->
            <!--$productBorderColor = match(true) {-->
            <!--$productActivePercent > 75 => 'primary', // Blue-->
            <!--$productActivePercent > 50 => 'success', // Green-->
            <!--$productActivePercent > 25 => 'warning', // Yellow-->
            <!--default => 'danger', // Red-->
            <!--};-->
            <!--$productGraphTextColor = match(true) {-->
            <!--$productActivePercent > 50 => 'text-white', // Green-->
            <!--default => 'text-dark', // Red-->
            <!--};-->
            <!--@endphp-->
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$productBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <!--<div>-->
                        <!--    <div class="kpi-card__title">WIP Order (Running Late)</div>-->
                        <!--    <div class="kpi-card__value">+{{ $totalActiveProducts }}</div>-->
                        <!--</div>-->
                        <!-- <div class="kpi-card__gauge {{ $productGraphTextColor }}" style="--gauge-value: {{ min($productActivePercent, 100) }}; --gauge-color: {{ $productColor }};">
                            {{ $productActivePercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
            <!--@php-->
            <!--$postsPercent = $totalPosts > 0 ? round(($totalActivePosts * 100) / $totalPosts) : 0;-->
            <!--$buyersColor = match(true) {-->
            <!--$postsPercent > 75 => '#0d6efd', // Blue-->
            <!--$postsPercent > 50 => '#198754', // Green-->
            <!--$postsPercent > 25 => '#ffc107', // Yellow-->
            <!--default => '#dc3545', // Red-->
            <!--};-->
            <!--$buyersBorderColor = match(true) {-->
            <!--$postsPercent > 75 => 'primary', // Blue-->
            <!--$postsPercent > 50 => 'success', // Green-->
            <!--$postsPercent > 25 => 'warning', // Yellow-->
            <!--default => 'danger', // Red-->
            <!--};-->
            <!--$buyersGraphTextColor = match(true) {-->
            <!--$postsPercent > 50 => 'text-white', // Green-->
            <!--default => 'text-dark', // Red-->
            <!--};-->
            <!--@endphp-->
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$buyersBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <!--<div>-->
                        <!--    <div class="kpi-card__title">Dely made pending receipt</div>-->
                        <!--    <div class="kpi-card__value">+{{ $totalActivePosts }}</div>-->
                        <!--</div>-->
                        <!-- <div class="kpi-card__gauge {{ $buyersGraphTextColor }}" style="--gauge-value: {{ min($postsPercent, 100) }}; --gauge-color: {{ $buyersColor }};">
                            {{ $postsPercent }}%
                        </div> -->
                    </div>
                </div>
            </div> 
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-{{$gaugeBorderColor}}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <!--<div>-->
                        <!--    <div class="kpi-card__title">Dely made pending acceptance</div>-->
                        <!--    <div class="kpi-card__value text-dark">{{ $totalActiveSellers }}/{{ $totalSellers }}</div>-->
                        <!--</div>-->
                        <!-- <div class="kpi-card__gauge {{ $gaugeGraphTextColor }}" style="--gauge-value: {{ min($sellersPercent, 100) }}; --gauge-color: {{ $gaugeColor }};">
                            {{ $sellersPercent }}%
                        </div> -->
                    </div>
                </div>
            </div>
        </div> 
        <!-- Charts Row -->
         <div class="row g-4 mt-2 d-none">
            <!-- Seller Bidding Status Chart -->
            <div class="col-lg-8">
                <div class="card h-100">
                    <!--<div class="chart-card-header">-->
                    <!--    <h6 class="m-0 fw-bold">Seller Bidding Status</h6>-->
                    <!--    <div class="actions">-->
                    <!--        <a href="#" class="text-muted"><i class='bx bx-cog'></i></a>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <!--<div class="card-body">-->
                    <!--    <div class="chart-container">-->
                    <!--        <canvas id="trafficChart"></canvas>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
            </div>
            <!-- Income Chart -->
            <div class="col-lg-4">
                <div class="card h-100">
                    <!--<div class="chart-card-header">-->
                    <!--    <h6 class="m-0 fw-bold">Total Orders Completed</h6>-->
                    <!--    <a href="#" class="text-muted"><i class='bx bx-cog'></i></a>-->
                    <!--</div>-->
                    <!--<div class="card-body d-flex flex-column justify-content-center">-->
                    <!--    <div class="income-chart-wrapper">-->
                    <!--        <canvas id="incomeChart"></canvas>-->
                    <!--        <div class="income-chart-center-text">-->
                    <!--            <div class="percent-label">Percent</div>-->
                    <!--            <div class="percent-value">{{ $incomePercent }}</div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--    <div class="spendings-target">-->
                    <!--        <div class="d-flex justify-content-between">-->
                    <!--            <span>Spendings Target</span>-->
                    <!--            <span class="fw-bold">{{ $spendingPercent }}%</span>-->
                    <!--        </div>-->
                    <!--        <div class="progress mt-1">-->
                    <!--            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $spendingPercent }}%" aria-valuenow="{{ $spendingPercent }}" aria-valuemin="0" aria-valuemax="100"></div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
            </div>
        </div> 
        <div class="row g-4 mt-2 d-none">
            <!-- Seller Bidding Status Chart -->
            <!--<div class="col-lg-8">-->
            <!--    <div class="card h-100">-->
            <!--        <div class="chart-card-header">-->
            <!--            <h6 class="m-0 fw-bold">Seller Bidding Status</h6>-->
            <!--            <div class="actions">-->
            <!--                <a href="#" class="text-muted"><i class='bx bx-cog'></i></a>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--        <div class="card-body">-->
            <!--            <div class="chart-container">-->
            <!--                <canvas id="trafficChart"></canvas>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <!-- Income Chart -->
            <!--<div class="col-lg-4">-->
            <!--    <div class="card h-100">-->
            <!--        <div class="chart-card-header">-->
            <!--            <h6 class="m-0 fw-bold">Total Orders Completed</h6>-->
            <!--            <a href="#" class="text-muted"><i class='bx bx-cog'></i></a>-->
            <!--        </div>-->
            <!--        <div class="card-body d-flex flex-column justify-content-center">-->
            <!--            <div class="income-chart-wrapper">-->
            <!--                <canvas id="incomeChart"></canvas>-->
            <!--                <div class="income-chart-center-text">-->
            <!--                    <div class="percent-label">Percent</div>-->
            <!--                    <div class="percent-value">{{ $incomePercent }}</div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="spendings-target">-->
            <!--                <div class="d-flex justify-content-between">-->
            <!--                    <span>Spendings Target</span>-->
            <!--                    <span class="fw-bold">{{ $spendingPercent }}%</span>-->
            <!--                </div>-->
            <!--                <div class="progress mt-1">-->
            <!--                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $spendingPercent }}%" aria-valuenow="{{ $spendingPercent }}" aria-valuemin="0" aria-valuemax="100"></div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
        </div> 
        <!-- Charts Row -->
        <div class="row g-4 mt-2 d-none">
            <!-- Seller Bidding Status Chart -->
            <!--<div class="col-lg-8">-->
            <!--    <div class="card h-100">-->
            <!--        <div class="chart-card-header">-->
            <!--            <h6 class="m-0 fw-bold">Seller Bidding Status</h6>-->
            <!--            <div class="actions">-->
            <!--                <a href="#" class="text-muted"><i class='bx bx-cog'></i></a>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--        <div class="card-body">-->
            <!--            <div class="chart-container">-->
            <!--                <canvas id="trafficChart"></canvas>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <!-- Income Chart -->
            <!--<div class="col-lg-4">-->
            <!--    <div class="card h-100">-->
            <!--        <div class="chart-card-header">-->
            <!--            <h6 class="m-0 fw-bold">Total Orders Completed</h6>-->
            <!--            <a href="#" class="text-muted"><i class='bx bx-cog'></i></a>-->
            <!--        </div>-->
            <!--        <div class="card-body d-flex flex-column justify-content-center">-->
            <!--            <div class="income-chart-wrapper">-->
            <!--                <canvas id="incomeChart"></canvas>-->
            <!--                <div class="income-chart-center-text">-->
            <!--                    <div class="percent-label">Percent</div>-->
            <!--                    <div class="percent-value">{{ $incomePercent }}</div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="spendings-target">-->
            <!--                <div class="d-flex justify-content-between">-->
            <!--                    <span>Spendings Target</span>-->
            <!--                    <span class="fw-bold">{{ $spendingPercent }}%</span>-->
            <!--                </div>-->
            <!--                <div class="progress mt-1">-->
            <!--                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $spendingPercent }}%" aria-valuenow="{{ $spendingPercent }}" aria-valuemin="0" aria-valuemax="100"></div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
        </div>
    </div>
</section>
@endsection
@section('footlink')
<!-- Scripts -->
<script src="{{ asset('/assets/backend/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script>
    const trafficChartCtx = document.getElementById('trafficChart').getContext('2d');
    const chartData = @json($orderStats);
    const trafficChart = new Chart(trafficChartCtx, {
        data: {
            labels: chartData.labels,
            datasets: [{
                type: 'bar',
                label: 'Buyer Orders',
                data: chartData.buyerOrders,
                backgroundColor: '#0d6efd',
                borderRadius: 4,
                yAxisID: 'y',
            }, {
                type: 'line',
                label: 'Seller Biddings',
                data: chartData.sellerBiddings,
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                pointBackgroundColor: '#198754',
                pointBorderColor: '#fff',
                pointHoverRadius: 6,
                pointHoverBorderWidth: 2,
                tension: 0.4,
                fill: false,
                yAxisID: 'y1',
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Buyer Orders'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Seller Biddings'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                },
            }
        }
    });
    const incomeCtx = document.getElementById('incomeChart').getContext('2d');
    const incomeGradient = incomeCtx.createLinearGradient(0, 0, 0, 200);
    incomeGradient.addColorStop(0, '#198754');
    incomeGradient.addColorStop(1, '#0d6efd');
    const incomeChart = new Chart(incomeCtx, {
        type: 'doughnut',
        data: {
            labels: ["Completed", "Remaining"],
            datasets: [{
                data: [{
                    {
                        $incomePercent
                    }
                }, {
                    {
                        100 - $incomePercent
                    }
                }],
                backgroundColor: [incomeGradient, '#e9ecef'],
                borderWidth: 0,
                borderRadius: 10,
            }],
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            cutout: '80%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            },
        },
    });
    document.querySelector('.percent-value').innerText = '{{ $incomePercent }}';
    document.querySelector('.progress-bar').style.width = '{{ $spendingPercent }}%';
    document.querySelector('.spendings-target span.fw-bold').innerText = '{{ $spendingPercent }}%';
</script>
@endsection