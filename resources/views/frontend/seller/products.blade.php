@include('.frontend.seller.inc.header')
<style>
    @media(max-width:768px){
     .live-auction-section{
        z-index: 0;
     } 
     .auction-card1 .auction-content h4{
        font-size: 16px;
    }
    .auction-content h4 {
        min-height: 0px !important;
    } 
} 
</style>
    <div class="inner-banner">
        <div class="container">
            <h2 class="inner-banner-title wow fadeInLeft text-center" data-wow-duration="1.5s" data-wow-delay=".2s">
                {{ $pagetitle ?? 'Products' }}
            </h2>
        </div>
    </div>
    
    <div class="live-auction-section pt-120 pb-120">
        <!--<img alt="image" src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-top">
        <img alt="image" src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-bottom">-->
        <div class="container">
            <div class="row gy-4 mb-60 d-flex justify-content-center">
                @php
                
                    $now = \Carbon\Carbon::now();
                    
                @endphp
                
                @if(count($products)>0)
                
                    @foreach($products as $product)
                        @php
                            
                            $auctionEnd = !empty($product->auction_end)
                                ? \Carbon\Carbon::parse($product->auction_end)
                                : null;
                                
                        @endphp
                    
                        <div class="col-6 col-lg-3 col-md-6 col-sm-10">
                            <div class="eg-card auction-card1 wow animate fadeInDown" data-wow-duration="1.5s" data-wow-delay="0.2s">
                                <div class="auction-img">
                                    <img alt="{{ $product->name ?? 'Unknown' }}" src="/public/assets/frontend/img/products/{{ $product->img ?? 'Unknown' }}">
                                </div>
                                <div class="auction-content">
                                    <div class="auction-timer">
                                        @if($auctionEnd && \Carbon\Carbon::parse($auctionEnd)->isFuture())
                                            <div class="countdown" data-endtime="{{ $auctionEnd->toIso8601String() }}">
                                                <h4 class="text-success">
                                                    <span class="hours">00</span>H :
                                                    <span class="minutes">00</span>M :
                                                    <span class="seconds">00</span>S
                                                </h4>
                                            </div>
                                        @elseif(empty($product->auction_end))
                                            <span class="msg text-primary fw-600 d-block mb-2">Coming Soon</span>
                                        @else
                                            <span class="msg text-danger fw-600 d-block mb-2">Bidding Closed</span>
                                        @endif
                                    </div>
                                    <h4><a href="/seller/product/{{ $product->slog ?? 'unknown' }}/{{ $product->id ?? 'Unknown' }}">{{ $product->name ?? 'Unknown' }}</a></h4>
                                    <h5 class="subtext-gray">(Qty: {{ $product->quantity ?? null }} {{ $product->uom ?? '' }}, EDD: {!! date_format(date_create($product->delivery_date ?? null),'d M, Y') !!})</h5>
                                    <div class="auction-card-bttm">
                                        <a href="/seller/product/{{ $product->slog ?? 'unknown' }}/{{ $product->id ?? 'Unknown' }}" class="eg-btn btn--primary btn--sm">Place your Bid</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                      <div class="text-center py-5 my-5 border rounded bg-light">
                        <h5 class="mb-2">No Live Bidding Found</h5>
                        <p class="text-muted mb-0">Check back later or refresh the page.</p>
                      </div>
                    </div>
                @endif
            </div>
            <div class="row d-none">
                <nav class="pagination-wrap">
                    <ul class="pagination d-flex justify-content-center gap-md-3 gap-2">
                        <li class="page-item">
                            <a class="page-link" href="#" tabindex="-1">Prev</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">01</a></li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">02</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">03</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const countdowns = document.querySelectorAll('.countdown');
        
            countdowns.forEach(function (countdown) {
                const endTimeStr = countdown.getAttribute('data-endtime');
                const endTime = new Date(endTimeStr).getTime();
        
                const hoursEl = countdown.querySelector('.hours');
                const minutesEl = countdown.querySelector('.minutes');
                const secondsEl = countdown.querySelector('.seconds');
        
                function updateCountdown() {
                    const now = new Date().getTime();
                    const distance = endTime - now;
        
                    if (distance <= 0) {
                        countdown.innerHTML = "<h4>Auction Ended</h4>";
                        clearInterval(interval);
                        return;
                    }
        
                    const hours = Math.floor(distance / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
                    if (hoursEl && minutesEl && secondsEl) {
                        hoursEl.textContent = String(hours).padStart(2, '0');
                        minutesEl.textContent = String(minutes).padStart(2, '0');
                        secondsEl.textContent = String(seconds).padStart(2, '0');
                    }
                }
        
                updateCountdown();
                const interval = setInterval(updateCountdown, 1000);
            });
        });
    </script>

@include('.frontend.seller.inc.footer')