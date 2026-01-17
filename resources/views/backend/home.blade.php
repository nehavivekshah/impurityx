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
        padding: 1rem;
    }
    .kpi-card__title {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    .kpi-card__value {
        /*font-size: 2rem;*/
        font-size: 1.5em;
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
    }.flex {
        padding: 0px 0px;
    }
    @media(min-width:768px) {
        .admin-dashboard-grid .col-xl-3 {
            width: 20%;
        }
        .admin-dashboard-grid .card .card-body {
            min-height: 130px;
        }
    }
    .text-black .col div{
        font-weight: 600;
    }
</style>
@php
function formatIndianAmount($num)
{
    $num = floatval($num);

    if ($num >= 10000000) {
        return number_format($num / 10000000, 2) . ' Cr';
    } elseif ($num >= 100000) {
        return number_format($num / 100000, 2) . ' L';
    } elseif ($num >= 1000) {
        return number_format($num / 1000, 2) . ' K';
    }

    return number_format($num, 2);
} 
@endphp
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
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Bid Initiated, Pending with Admin</div>
                            <div class="kpi-card__value">#{{ $AdminNotActiveBidsCount ?? '0' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Bid Accepted, Pending With Admin</div>
                            <div class="kpi-card__value">#{{ $AdminPendingBidsCount ?? '0' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">New Buyer Regn Request</div>
                            <div class="kpi-card__value text-dark">#{{ $newBuyersCount ?? '0' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">New Seller Regn Request</div>
                            <div class="kpi-card__value text-dark">#{{ $newSellersCount ?? '0' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">New Inter Party Mail</div>
                            <div class="kpi-card__value text-dark">#{{ $AdminInterMailCount ?? '0' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 my-2 admin-dashboard-grid">
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">New Products Request received</div>
                            <div class="kpi-card__value">#{{ $nprCount ?? '0' }}</div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row my-2 mt-4">
            <div class="col-md-12">
                <h2 class="fw-bold mb-0 text-dark">Bidding :</h2>
            </div>
        </div>
        
        @php
        // Final Values
        $mtdCount = $mtd->count ?? 0;
        $ytdCount = $ytd->count ?? 0;
        $ctdCount = $ctd->count ?? 0;
        
        $mtdAmount = $mtd->amount ?? 0;
        $ytdAmount = $ytd->amount ?? 0;
        $ctdAmount = $ctd->amount ?? 0;
        @endphp
        
        <div class="row g-4 my-2 admin-dashboard-grid">
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Active Bids Count</div>
                            <div class="kpi-card__value">#{{ $myActiveBidsCount ?? '0' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Non Active Bids Count</div>
                            <div class="kpi-card__value">#{{ $myNonActiveBidsCount ?? '0' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Active and Participated Bids Count</div>
                            <div class="kpi-card__value text-dark">#{{ $myAPBidsCount ?? '0' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Bids Closed, - pending with Customers</div>
                            <div class="kpi-card__value text-dark">#{{ $myABBidsCount ?? '0' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Buyer - Accepted, Pending with Admin</div>
                            <div class="kpi-card__value text-dark">#{{ $myAABidsCount ?? '0' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 my-2 admin-dashboard-grid">
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div style="width: 100%;">
                            <div class="kpi-card__title">Bid Won Count</div>
                            <div class="flex mt-2 text-black" style="display:flex;gap:5px;justify-content:space-between;">
                                <div class="col">
                                    <div>MTD</div>
                                    <div>#{{ $mtdCount }}</div>
                                    <div>{{ formatIndianAmount($mtdAmount, 2) }}</div>
                                </div>
                        
                                <div class="col">
                                    <div>YTD</div>
                                    <div>#{{ $ytdCount }}</div>
                                    <div>{{ formatIndianAmount($ytdAmount, 2) }}</div>
                                </div>
                        
                                <div class="col">
                                    <div>CTD</div>
                                    <div>#{{ $ctdCount }}</div>
                                    <div>{{ formatIndianAmount($ctdAmount, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">No. of Buyers in Active Bid</div>
                            <div class="kpi-card__value">#{{ $myBuyerActiveCount ?? '0' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">No. of Sellers in Active Bid</div>
                            <div class="kpi-card__value text-dark">#{{ $mySellerActiveCount ?? '0' }}</div>
                        </div>
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
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">WIP Order</div>
                            <div class="kpi-card__value">#{{ $wipOrdercount }} 
                           Rs. {{ formatIndianAmount($wipOrderAmt, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Active & Participated Ord Val</div>
                            <div class="kpi-card__value"><!--#{{ $otcOrdercount }} -->
                           Rs. {{ formatIndianAmount($otcOrderAmt, 2) }} </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
            // Final Values
            $oCmtdCount = $oCmtd->count ?? 0;
            $oCytdCount = $oCytd->count ?? 0;
            $oCctdCount = $oCctd->count ?? 0;
            
            $oCmtdAmount = $oCmtd->amount ?? 0;
            $oCytdAmount = $oCytd->amount ?? 0;
            $oCctdAmount = $oCctd->amount ?? 0;
            @endphp
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div style="width:100%;">
                            <div class="kpi-card__title">Bid Won Count</div>
                            <div class="flex mt-2 text-black" style="display:flex; justify-content:space-between;">
                                <div class="col">
                                    <div>MTD</div>
                                    <div>#{{ $mtdCount }}</div>
                                    <div>{{ formatIndianAmount($mtdAmount, 2) }}</div>
                                </div>
                        
                                <div class="col">
                                    <div>YTD</div>
                                    <div>#{{ $ytdCount }}</div>
                                    <div>{{ formatIndianAmount($ytdAmount, 2) }}</div>
                                </div>
                        
                                <div class="col">
                                    <div>CTD</div>
                                    <div>#{{ $ctdCount }}</div>
                                    <div>{{ formatIndianAmount($ctdAmount, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div style="width:100%;">
                            <div class="kpi-card__title">Orders Completed</div>
                            <div class="flex mt-2 text-black" style="display:flex; justify-content:space-between;">
                                <div class="col">
                                    <div>MTD</div>
                                    <div>#{{ $oCmtdCount }}</div>
                                    <div>{{ formatIndianAmount($oCmtdAmount, 2) }}</div>
                                </div>
                        
                                <div class="col">
                                    <div>YTD</div>
                                    <div>#{{ $oCytdCount }}</div>
                                    <div>{{ formatIndianAmount($oCytdAmount, 2) }}</div>
                                </div>
                        
                                <div class="col">
                                    <div>CTD</div>
                                    <div>#{{ $oCctdCount }}</div>
                                    <div>{{ formatIndianAmount($oCctdAmount, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 my-2 admin-dashboard-grid">
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Total Sellers Onboarded</div>
                            <div class="kpi-card__value">#{{ $totalSellersCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Active Sellers Onboarded</div>
                            <div class="kpi-card__value">#{{ $totalActiveSellersCount }}</div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Total Buyers Onboarded</div>
                            <div class="kpi-card__value text-dark">#{{ $totalBuyersCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Active Buyers Count</div>
                            <div class="kpi-card__value text-dark">#{{ $totalActiveBuyersCount }}</div>
                        </div>
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
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">WIP Order (Running Late)</div>
                            <div class="kpi-card__value">#{{ $dilOrdercount }} 
                           Rs. {{ formatIndianAmount($dilOrderAmt, 2) }} </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Dely made pending receipt</div>
                            <div class="kpi-card__value">#{{ $dilOrdercount }} 
                           Rs. {{ formatIndianAmount($dilOrderAmt, 2) }} </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card kpi-card border-bottom-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-card__title">Dely made pending acceptance</div>
                            <div class="kpi-card__value text-dark">#{{ $completelOrdercount }} 
                           Rs. {{ formatIndianAmount($completelOrderAmt, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footlink')
<!-- Scripts -->
<script src="{{ asset('/assets/backend/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
@endsection