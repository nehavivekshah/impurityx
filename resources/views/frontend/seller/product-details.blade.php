@include('.frontend.seller.inc.header')
@php
$galleries = json_decode(($product->gallery ?? ''), true);
$user = session('users');
@endphp
<style>
    .product-details-enhanced h3 {
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
        border-bottom: 2px solid #0d6efd;
        padding-bottom: 10px;
    }
    /* Styling for the primary product info grid */
    .product-info-grid .info-label {
        font-weight: 600;
        color: #555;
    }
    .product-info-grid .info-value {
        color: #212529;
    }
    .product-info-grid .row {
        margin-bottom: 0.75rem;
    }
    /* --- Key Enhancement: Highlighting Buyer Requirements --- */
    .buyer-requirements-box {
        background-color: #fff3cd;
        /* A soft warning yellow */
        border: 1px solid #ffeeba;
        border-left: 5px solid #ffc107;
        /* Prominent left border */
        padding: 20px;
        border-radius: 8px;
        margin-top: 25px;
        margin-bottom: 25px;
    }
    .buyer-requirements-box h5 {
        font-weight: 700;
        color: #856404;
        /* Darker text for contrast */
        margin-top: 0;
        margin-bottom: 15px;
    }
    .buyer-requirements-box .requirement-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        font-size: 1rem;
    }
    .buyer-requirements-box .requirement-item i {
        color: #ffc107;
        margin-right: 12px;
        font-size: 1.2rem;
        width: 20px;
        /* Aligns the text vertically */
        text-align: center;
    }
    .buyer-requirements-box .requirement-item strong {
        color: #664d03;
        min-width: 135px;
        /* Ensures labels are aligned */
    }
    /* Enhancements for the Bid Form & Table */
    .bid-card {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
    }
    .countdown-timer {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 6px;
        text-align: center;
        font-size: 0.9rem;
    }
    .countdown-timer .time {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: #dc3545;
        /* A red color to create urgency */
        letter-spacing: 1px;
    }
    .countdown-timer .date {
        font-size: 0.85rem;
        color: #6c757d;
    }
    /* Ongoing Bids Table */
    .ongoing-bid-table th {
        background-color: #ffc107;
        color: #333;
        font-weight: 600;
    }
    /* Highlight the leading bid (assuming it's the first row) */
    .ongoing-bid-table .leading-bid {
        background-color: #d1e7dd;
        /* A light green to indicate success/leading */
        font-weight: 600;
    }
    .ongoing-bid-table .leading-bid td {
        border-top: 2px solid #198754;
        border-bottom: 2px solid #198754;
    }
    .account-btn-submit {
        width: 100%;
        padding: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        background-color: #0d6efd;
        color: white;
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.2s;
    }
    .account-btn-submit:hover {
        background-color: #0b5ed7;
        transform: translateY(-2px);
    }
    .requirement-item a {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    @media(max-width:768px){
        .big-image img { 
            height: 30vh;
        }
    }
</style>
<div class="inner-banner">
    <div class="container">
        <h2 class="inner-banner-title text-center wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".4s">
            My Bidding
        </h2>
    </div>
</div>
<div class="auction-details-section pt-120">
    <img src="/public/assets/frontend/images/bg/section-bg.png" alt="section-bg" class="img-fluid section-bg-top">
    <img src="/public/assets/frontend/images/bg/section-bg.png" alt="section-bg" class="img-fluid section-bg-bottom">
    <div class="container">
        <!-- product-details-container start-->
        <div class="row g-4 mb-50 product-details-container">
            <!-- image-column start-->
            <div
                class="col-xl-5 col-lg-7 d-flex flex-column align-items-start justify-content-lg-start justify-content-center flex-md-nowrap flex-wrap gap-4 sticky-md-top">
                <div class="slide-content">
                    <div class="tab-content d-flex justify-content-lg-start justify-content-center wow fadeInUp"
                        data-wow-duration="1.5s" data-wow-delay=".4s">
                        @if(!empty($product->img))
                        <div class="tab-pane1 big-image fade show active" id="gallery-img1">
                            <img alt="{{ $product->img }}" name="gallery-img1"
                                src="{{ asset('public/assets/frontend/img/products/' . $product->img) }}"
                                class="img-fluid">
                        </div>
                        @endif
                        @if(!empty($galleries) && is_iterable($galleries))
                        @foreach($galleries as $k => $gallery)
                        <div class="tab-pane1 big-image fade" id="gallery-img{{ $k + 2 }}">
                            <img alt="{{ $gallery }}" name="gallery-img{{ $k + 2 }}"
                                src="{{ asset('public/assets/frontend/img/products/' . $gallery) }}"
                                class="img-fluid">
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <ul class="nav small-image-list d-flex flex-md-row flex-row justify-content-center gap-4 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".4s">
                        @if(!empty($galleries) && is_iterable($galleries))
                        @if(!empty($product->img))
                        <li class="nav-item">
                            <div id="details-img1" data-bs-toggle="pill" data-bs-target="#gallery-img1" aria-controls="gallery-img1">
                                <img alt="{{ $product->img }}" name="details-img1"
                                    src="{{ asset('public/assets/frontend/img/products/' . $product->img) }}"
                                    class="img-fluid">
                            </div>
                        </li>
                        @endif
                        @foreach($galleries as $k => $gallery)
                        <li class="nav-item">
                            <div id="details-img{{ $k + 2 }}" data-bs-toggle="pill"
                                data-bs-target="#gallery-img{{ $k + 2 }}" aria-controls="gallery-img{{ $k + 2 }}">
                                <img alt="{{ $gallery }}" name="details-img{{ $k + 2 }}"
                                    src="{{ asset('public/assets/frontend/img/products/' . $gallery) }}"
                                    class="img-fluid">
                            </div>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <!-- image-column end-->
            <!-- content-column start-->
            <div class="col-xl-7 col-lg-5 content-column">
                <div class="product-details-enhanced wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                    <!-- Product Name -->
                    <h3>{{ $product->name ?? 'Unknown Name' }}</h3>
                    <!-- Section for Product Technical Details -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <strong>Product Specifications</strong>
                        </div>
                        <div class="card-body product-info-grid">
                            <div class="row">
                                @if(!empty($product->orderId))
                                @php
                                
                                $month = date('m', strtotime($product->created_at));
                                $year = date('Y', strtotime($product->created_at));
                                
                                if ($month >= 3) {
                                    // March to Dec
                                    $fy_start = date('y', strtotime($product->created_at));
                                    $fy_end = date('y', strtotime('+1 year', strtotime($product->created_at)));
                                } else {
                                    // Jan-Feb
                                    $fy_start = date('y', strtotime('-1 year', strtotime($product->created_at)));
                                    $fy_end = date('y', strtotime($product->created_at));
                                }
                                
                                $financialYear = $fy_start . '' . $fy_end;
                                
                                @endphp
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-5 info-label">Order Id:</div>
                                        <div class="col-7 info-value">{{ $financialYear }}</div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($product->sku))
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-5 info-label">SKU:</div>
                                        <div class="col-7 info-value">{{ $product->sku }}</div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($product->synonym))
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-5 info-label">Synonym Name:</div>
                                        <div class="col-7 info-value">{{ $product->synonym }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                @if(!empty($product->cas_no))
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-5 info-label">CAS No.:</div>
                                        <div class="col-7 info-value">{{ $product->cas_no }}</div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($product->impurity_type))
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-5 info-label">Impurity Type:</div>
                                        <div class="col-7 info-value">{{ $product->impurity_type }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                @if(!empty($product->uom))
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-5 info-label">UOM:</div>
                                        <div class="col-7 info-value">{{ $product->uom }}</div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($product->purity))
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-5 info-label">Purity:</div>
                                        <div class="col-7 info-value">{{ $product->purity }}%</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="buyer-requirements-box">
                        <h5><i class="fas fa-bullseye"></i> Buyer's Requirements</h5>
                        @if(!empty($product->quantity))
                        <div class="requirement-item">
                            <i class="fas fa-box-open"></i>
                            <strong>Qty. Required:</strong> {{ $product->quantity }} {{ $product->uom }}
                        </div>
                        @endif
                        @if(!empty($product->delivery_date))
                        <div class="requirement-item">
                            <i class="fas fa-calendar-alt"></i>
                            <strong>Delivery Date:</strong> {{ \Carbon\Carbon::parse($product->delivery_date)->format('d-M-Y') }}
                        </div>
                        @endif
                        @if(!empty($product->delivery_location))
                        <div class="requirement-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <strong>Delivery At:</strong> {{ $product->delivery_location }}
                        </div>
                        @endif
                        @php
                        // Decode JSON into array
                        $attachments = $product->attachments ? json_decode($product->attachments, true) : [];
                        @endphp
                        @if(count($attachments))
                        <div class="requirement-item">
                            <i class="fas fa-paperclip"></i>
                            <strong>Attachments:</strong>
                            @foreach($attachments as $attachment)
                            <a href="/public/assets/frontend/img/products/files/{{ basename($attachment) }}" target="_blank">
                                {{ basename($attachment) }}
                            </a>
                            @if(!$loop->last), @endif
                            @endforeach
                        </div>
                        @endif
                        @if(!empty($product->specific_requirements))
                        <div class="requirement-item">
                            <i class="fas fa-file-alt"></i>
                            <strong>Specific Notes:</strong> {!! $product->specific_requirements !!}
                        </div>
                        @endif
                    </div>
                    <!-- Form for Bidding -->
                    <div class="row gy-4">
                        <!-- My Bid Section -->
                        <div class="col-12">
                            <div class="card bid-card">
                                <div class="card-header bg-success text-white text-center">
                                    <h5 class="mb-0">Place Your Bid</h5>
                                </div>
                                <div class="card-body">
                                    <form action="/seller/product/{{ $product->slog ?? 'unknown-name' }}/{{ $product->orderId ?? '' }}" method="POST" class="w-100 form-wrapper form-products">
                                        @csrf
                                        <div class="row align-items-center gy-3">
                                            <div class="col-lg-12 col-md-12 mt-0">
                                                @php
                                                $now = \Carbon\Carbon::now();
                                                $auctionEnd = !empty($product->auction_end)
                                                ? \Carbon\Carbon::parse($product->auction_end)
                                                : null;
                                                @endphp
                                                @if($auctionEnd && ($product->auction_end > $now))
                                                <div class="countdown-timer" data-end="{{ $auctionEnd->toIso8601String() }}">
                                                    Auction ending in
                                                    <span class="time">--H : --M : --S</span>
                                                    <span class="date">at {{ $auctionEnd->format('d-M-Y H:i:s') }}</span>
                                                </div>
                                                @else
                                                <div class="countdown-timer">
                                                    <span class="msg">Auction date not available</span>
                                                </div>
                                                @endif
                                            </div>
                                            @if($auctionEnd && ($product->auction_end > $now))
                                            <div class="col-lg-3 col-md-4">
                                                <label for="priceP-u" class="form-label fw-bold" style="padding-left: 0px;">Price (₹) per {{ $product->uom ?? 'Unit' }}</label>
                                                <input type="number" class="form-control" id="priceP-u" name="price" min="1" placeholder="0.00" required>
                                                <!--max="{{ $product->min_bid_price ?? '' }}"-->
                                                <input type="hidden" name="order_id" value="{{ $product->orderId ?? '' }}">
                                                <input type="hidden" name="seller_id" value="{{ $user->id ?? '' }}" />
                                            </div>
                                            <div class="col-lg-3 col-md-4">
                                                <label for="delivery-days" class="form-label fw-bold" style="padding-left: 0px;">Delivery Days</label>
                                                <input type="number" class="form-control" id="delivery-days" name="days" min="1" placeholder="30" value="30" required="">
                                            </div>
                                            <div class="col-lg-6 col-md-4">
                                                <label class="form-label fw-bold" style="padding-left: 0px;">Storage Temp (°C)</label>
                                                <div class="input-group">
                                                    <input type="number" step="any" class="form-control text-end" name="storage-temp-min" id="temp-min" placeholder="-8" required>
                                                    <span class="input-group-text">to</span>
                                                    <input type="number" step="any" class="form-control text-end" name="storage-temp-max" id="temp-max" placeholder="2" required>
                                                </div>
                                                <small id="temp-error" class="text-danger d-none">Max temp must be greater than or equal to Min temp.</small>
                                            </div>
                                            <div class="col-12">
                                                <button class="account-btn-submit" type="submit">Submit My Bid</button>
                                            </div>
                                            @elseif(empty($auctionEnd))
                                            <div class="col-12">
                                                <div class="alert alert-warning fw-bold mb-0 text-center">
                                                    Coming Soon
                                                </div>
                                            </div>
                                            @else
                                            <div class="col-12">
                                                <div class="alert alert-danger fw-bold mb-0 text-center">
                                                    This auction has ended. Bidding is closed.
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Ongoing Bid Section -->
                        <div class="col-12">
                            <div class="card bid-card">
                                <div class="card-header bg-warning">
                                    <h5 class="mb-0">Ongoing Bids</h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover mb-0 ongoing-bid-table">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Offer</th>
                                                    <th>Rate p.u.</th>
                                                    <th>Delivery</th>
                                                    <th>Storage (°C)</th>
                                                    <th>Bid Time</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                @forelse($biddings as $k => $bidding)
                                                <tr class="{!! (count($biddings)) - ($k) !!}">
                                                    <td>@if(Auth::id() == $bidding->seller_id) * @endif{!! (count($biddings)) - ($k) !!}</td>
                                                    @if(($product->bid_view_status == '1') || (Auth::id() == $bidding->seller_id))
                                                    <td>₹{{ number_format($bidding->price, 2) }}</td>
                                                    <td>{{ $bidding->days }} Days</td>
                                                    <td>{{ $bidding->temp }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($bidding->created_at)->format('d-m-Y H:i') }}</td>
                                                    @else
                                                    <td>--</td>
                                                    <td>--</td>
                                                    <td>--</td>
                                                    <td>--</td>
                                                    @endif
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-muted">No bids yet.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-column end-->
        </div>
        <!-- product-details-container end-->
        <!-- Product Tabs -->
        <div class="row d-flex justify-content-center g-4">
            <div class="col-lg-12">
                <ul class="nav nav-pills describe-pills d-flex flex-row justify-content-start gap-sm-4 gap-3 mb-45 wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay=".2s" id="pills-tab" role="tablist">
                    @if(!empty($product->des))
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active details-tab-btn" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Products Description</button>
                    </li>
                    @endif
                    @if(!empty($product->ainfo))
                    <li class="nav-item" role="presentation">
                        <button class="nav-link details-tab-btn" id="pills-bid-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-bid" type="button" role="tab" aria-controls="pills-bid"
                            aria-selected="false">Additional Information</button>
                    </li>
                    @endif
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    @if(!empty($product->des))
                    <div class="tab-pane fade show active wow fadeInUp" data-wow-duration="1.5s"
                        data-wow-delay=".2s" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="describe-content">
                            {!! $product->des ?? '' !!}
                        </div>
                    </div>
                    @endif
                    @if(!empty($product->ainfo))
                    <div class="tab-pane fade" id="pills-bid" role="tabpanel" aria-labelledby="pills-bid-tab">
                        <div class="table-responsive">
                            {!! $product->ainfo ?? '' !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="about-us-counter pt-120 pb-120">
    <div class="container">
        <div class="row g-4 d-flex justify-content-center">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay="0.3s">
                    <div class="counter-icon"> <img src="/public/assets/frontend/img/icon/counter/1.png" alt="Happy Customer"></div>
                    <div class="coundown d-flex flex-column">
                        <h3 class="odometer" data-odometer-final="400"> </h3>
                        <p>Happy Customer</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay="0.6s">
                    <div class="counter-icon"> <img src="/public/assets/frontend/img/icon/counter/2.png" alt="Good Reviews"> </div>
                    <div class="coundown d-flex flex-column">
                        <h3 class="odometer" data-odometer-final="250"> </h3>
                        <p>Good Reviews</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay="0.9s">
                    <div class="counter-icon"> <img src="/public/assets/frontend/img/icon/counter/3.png" alt="Verified Suppliers"> </div>
                    <div class="coundown d-flex flex-column">
                        <h3 class="odometer" data-odometer-final="350"> </h3>
                        <p>Verified Suppliers</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay=".8s">
                    <div class="counter-icon"> <img src="/public/assets/frontend/img/icon/counter/4.png" alt="Buyer Satisfaction"> </div>
                    <div class="coundown d-flex flex-column">
                        <h3 class="odometer" data-odometer-final="500"> </h3>
                        <p>Buyer Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const minInput = document.getElementById('temp-min');
        const maxInput = document.getElementById('temp-max');
        const errorText = document.getElementById('temp-error');
        function validateTemperature() {
            const min = parseFloat(minInput.value);
            const max = parseFloat(maxInput.value);
            if (!isNaN(min) && !isNaN(max)) {
                if (max < min) {
                    errorText.classList.remove('d-none');
                    maxInput.setCustomValidity('Max must be greater than or equal to Min');
                } else {
                    errorText.classList.add('d-none');
                    maxInput.setCustomValidity('');
                }
            } else {
                errorText.classList.add('d-none');
                maxInput.setCustomValidity('');
            }
        }
        minInput.addEventListener('input', validateTemperature);
        maxInput.addEventListener('input', validateTemperature);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timerElement = document.querySelector('.countdown-timer');
        if (!timerElement) return;
        const timeSpan = timerElement.querySelector('.time');
        const endTime = new Date(timerElement.getAttribute('data-end'));
        function updateCountdown() {
            const now = new Date();
            const diff = endTime - now;
            if (diff <= 0) {
                timeSpan.textContent = "00H : 00M : 00S";
                return;
            }
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            timeSpan.textContent =
                String(hours).padStart(2, '0') + "H : " +
                String(minutes).padStart(2, '0') + "M : " +
                String(seconds).padStart(2, '0') + "S";
        }
        updateCountdown(); // initial call
        setInterval(updateCountdown, 1000); // update every second
    });
</script>
<script>
    document.getElementById('priceP-u').addEventListener('input', function() {
        const max = parseFloat(this.max);
        const value = parseFloat(this.value);
        if (value >= max) {
            this.setCustomValidity(`Bid must be less than ${max}`);
        } else {
            this.setCustomValidity('');
        }
    });
</script>
@include('.frontend.seller.inc.footer')