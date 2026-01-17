@include('.frontend.seller.inc.header')
<style>
    @media (max-width: 767px){
        .special-mobile-responsive {
            height:100%;
            padding-top:0px;
            padding-bottom:50px;
        }
        .category-section .seller-category{
        z-index: 0;
    } 
    .hero-style-one{
        z-index: -99;
    } 
    .auction-card1 .auction-content h4{
        font-size: 16px;
    }
    .auction-content h4 {
        min-height: 0px !important;
    } 
}
</style>
@section('footlink')
<script>
    var swiper = new Swiper(".category1-slider", {
    slidesPerView: 1,
    speed: 1000,
    spaceBetween: 30,
    loop: true,
    autoplay: true,
    roundLengths: true,
    navigation: {
      nextEl: '.category-next1',
      prevEl: '.category-prev1',
    },

    breakpoints: {
        280:{
            slidesPerView: 2,
            spaceBetween: 10
          },
      440:{
        slidesPerView: 2,
        spaceBetween: 10
      },
      576:{
        slidesPerView: 2,
        spaceBetween: 10
      },
      768:{
        slidesPerView: 3,
        spaceBetween: 10
      },
      992:{ 
        slidesPerView: 5
      },
      1200:{
        slidesPerView: 6
      },
      1400:{
        slidesPerView: 7
      },  
    }
 
  });
 </script>
 @endsection
<div class="hero-area hero-style-one">
    <div class="hero-main-wrapper position-relative">
        <div class="swiper banner1 special-mobile-responsive">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                <style>
                    .slider-bg-{{ $slider->id }} {
                        content: "";
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background-size: cover;
                        background-position: center;
                        background-repeat: no-repeat;
                        z-index: -1;
                        /* -webkit-animation: large 26s linear infinite alternate;
                        animation: large 26s linear infinite alternate; */
                    }
                </style>
            
                <div class="swiper-slide">
                    <div class="slider-bg-{{ $slider->id }} position-relative overflow-hidden" style="background-image: url('{{ asset('public/assets/frontend/img/sliders/' . $slider->imgs) }}');">
                        <div class="container">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-xl-10 col-lg-10">
                                    <div class="banner1-content text-center">
                                        @if(!empty($slider->title))<h1>{{ $slider->title }}</h1>@endif
                                        @if(!empty($slider->subtitle))<p>{{ $slider->subtitle }}</p>@endif
                                        @if(!empty($slider->link))
                                            <a href="{{ $slider->link }}" class="eg-btn btn--primary btn--lg">
                                                {{ $slider->btntext ?? 'Learn More' }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
        <div class="hero-one-pagination d-flex justify-content-center flex-column align-items-center gap-3"></div>
    </div>
</div>

<div class="category-section pt-120 pb-120">
    <div class="container seller-category position-relative">
        <div class="row d-flex justify-content-center">
            <div class="swiper category1-slider">
                <div class="swiper-wrapper">
                    @foreach($categories as $category)
                    <div class="swiper-slide">
                        <a href="/seller/category/{{ $category->slog ?? 'Unknown' }}">
                            <div class="eg-card category-card1 wow animate fadeInDown" data-wow-duration="1500ms"
                                data-wow-delay="200ms">
                                <div class="cat-icon">
                                    <img class="img-fluid" src="/public/assets/frontend/img/category/icons/{{ $category->icon ?? 'Unknown' }}" alt="{{ $category->slog ?? 'Unknown' }}">
                                </div>
                                <h5>{{ $category->title ?? 'Unknown' }}</h5>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="slider-arrows text-center d-xl-flex d-none  justify-content-end">
            <div class="category-prev1 swiper-prev-arrow" tabindex="0" role="button" aria-label="Previous slide"> <i
                    class='bx bx-chevron-left'></i> </div>
            <div class="category-next1 swiper-next-arrow" tabindex="0" role="button" aria-label="Next slide"> <i
                    class='bx bx-chevron-right'></i></div>
        </div>
    </div>
</div>

<div class="live-auction pb-120">
    <img alt="image" src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg">
    <div class="container position-relative">
        <img alt="image" src="/public/assets/frontend/images/bg/dotted1.png" class="dotted1">
        <img alt="image" src="/public/assets/frontend/images/bg/dotted1.png" class="dotted2">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="section-title1">
                    <h2>Live Offers</h2>
                    <p class="mb-0">
                        Step into the action with ImpurityX Live Offers! When buyers list their needs, jump in with
                        your offer, outbid the competition, and win deals on the spot. It's fast, fair, and built for
                        suppliers ready to grow their business in real-time!
                    </p>
                </div>
            </div>
        </div>
        <div class="row gy-4 mb-60 d-flex justify-content-center">
            @foreach($products as $product)
                @php
                    $auctionEnd = !empty($product->auction_end)
                        ? \Carbon\Carbon::parse($product->auction_end)->format('Y-m-d H:i:s')
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
                                    <div class="countdown" data-endtime="{{ $auctionEnd }}">
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

        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-4 text-center product-btn">
                <a href="/seller/products" class="eg-btn btn--primary btn--md mx-auto btn-products">View All
                    Products</a>
            </div>
        </div>
    </div>
</div>

<!--<div class="testimonial-section pt-80 pb-80">
    <img alt="image" src="/public/assets/frontend/images/bg/client-right.png" class="client-right-vector">
    <img alt="image" src="/public/assets/frontend/images/bg/client-left.png" class="client-left-vector">
    <img alt="image" src="/public/assets/frontend/images/bg/clent-circle1.png" class="client-circle1">
    <img alt="image" src="/public/assets/frontend/images/bg/clent-circle2.png" class="client-circle2">
    <img alt="image" src="/public/assets/frontend/images/bg/clent-circle3.png" class="client-circle3">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="section-title1">
                    <h2>What Client Say</h2>
                    <p class="mb-0">Explore on the world's best & largest Bidding marketplace with our beautiful
                        Bidding
                        products. We want to be a part of your smile, success and future growth.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center position-relative">
            <div class="swiper testimonial-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testimonial-single hover-border1 wow fadeInDown" data-wow-duration="1.5s"
                            data-wow-delay=".2s">
                            <img alt="image" src="/public/assets/frontend/images/icons/quote-green.svg" class="quote-icon">
                            <div class="testi-img">
                                <img alt="image" src="/public/assets/frontend/images/bg/testi1.png">
                            </div>
                            <div class="testi-content">
                                <p class="para">The Pacific Grove Chamber of Commerce would like to thank eLab
                                    Communications and Mr. Will Elkadi for all the efforts that
                                    assisted.</p>
                                <div class="testi-designation">
                                    <h5><a href="blog.html">Johan Martin</a></h5>
                                    <p>CEO</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-single hover-border1 wow fadeInDown" data-wow-duration="1.5s"
                            data-wow-delay=".4s">
                            <img alt="image" src="/public/assets/frontend/images/icons/quote-green.svg" class="quote-icon">
                            <div class="testi-img">
                                <img alt="image" src="/public/assets/frontend/images/bg/testi2.png">
                            </div>
                            <div class="testi-content">
                                <p class="para">Nullam cursus tempor ex. Nullam nec dui id metus consequat congue ac
                                    at est. Pellentesque blandit neque at elit tristique tincidunt.</p>
                                <div class="testi-designation">
                                    <h5><a href="#">Jamie anderson</a></h5>
                                    <p>Manager</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-single hover-border1 wow fadeInDown" data-wow-duration="1.5s"
                            data-wow-delay=".4s">
                            <img alt="image" src="/public/assets/frontend/images/icons/quote-green.svg" class="quote-icon">
                            <div class="testi-img">
                                <img alt="image" src="/public/assets/frontend/images/bg/testi3.png">
                            </div>
                            <div class="testi-content">
                                <p class="para">Maecenas vitae porttitor neque, ac porttitor nunc. Duis venenatis
                                    lacinia libero. Nam nec augue ut nunc vulputate tincidunt at suscipit nunc. </p>
                                <div class="testi-designation">
                                    <h5><a href="#">John Peter</a></h5>
                                    <p>Area Manager</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider-arrows testimonial2-arrow d-flex justify-content-between gap-3">
                <div class="testi-prev1 swiper-prev-arrow" tabindex="0" role="button" aria-label="Previous slide"><i
                        class="bi bi-arrow-left"></i></div>
                <div class="testi-next1 swiper-next-arrow" tabindex="0" role="button" aria-label="Next slide">
                    <i class="bi bi-arrow-right"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="sponsor-section style-1 pb-4">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="section-title1">
                    <h2>Trusted By 500+ Businesses.</h2>
                    <p class="mb-0">
                        At Impurity X, we proudly serve a diverse portfolio of clients across the pharmaceutical,
                        biotech, chemical manufacturing, and research industries.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="slick-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.2s">
                <div id="slick1">
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor1.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor2.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor3.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor4.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor5.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor6.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor7.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor8.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor9.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor1.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor3.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor5.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor8.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor6.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor7.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor8.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor1.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor2.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor9.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor8.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor9.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor1.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor3.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor5.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor8.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor6.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor7.png"></div>
                    <div class="slide-item"><img alt="image" src="/public/assets/frontend/images/bg/sponsor8.png"></div>
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
                    <div class="counter-icon"> <img src="/public/assets/frontend/img/icon/counter/1.png" alt="employee"></div>
                    <div class="coundown d-flex flex-column">
                        <h3 class="odometer" data-odometer-final="400">&nbsp;</h3>
                        <p>Happy Customer</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay="0.6s">
                    <div class="counter-icon"> <img src="/public/assets/frontend/img/icon/counter/2.png" alt="review"> </div>
                    <div class="coundown d-flex flex-column">
                        <h3 class="odometer" data-odometer-final="250">&nbsp;</h3>
                        <p>Good Reviews</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay="0.9s">
                    <div class="counter-icon"> <img src="/public/assets/frontend/img/icon/counter/3.png" alt="smily"> </div>
                    <div class="coundown d-flex flex-column">
                        <h3 class="odometer" data-odometer-final="350">&nbsp;</h3>
                        <p>Verified Suppliers</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay=".8s">
                    <div class="counter-icon"> <img src="/public/assets/frontend/img/icon/counter/4.png" alt="comment"> </div>
                    <div class="coundown d-flex flex-column">
                        <h3 class="odometer" data-odometer-final="500">&nbsp;</h3>
                        <p>Buyer Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->

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
    
                if (distance < 0) {
                    countdown.innerHTML = "<h4>Auction Ended</h4>";
                    clearInterval(interval);
                    return;
                }
    
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
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