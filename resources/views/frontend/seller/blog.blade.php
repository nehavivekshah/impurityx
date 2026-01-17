@include('.frontend.seller.inc.header')
<body>
   
    <!-- ========== inner-page-banner start ============= -->
    <div class="inner-banner">
        <div class="container">
            <h2 class="inner-banner-title wow fadeInLeft text-center" data-wow-duration="1.5s" data-wow-delay=".2s">Our Blogs</h2> 
        </div>
    </div>

    <!-- ========== inner-page-banner end ============= -->
    <div class="blog-section pt-120 pb-120">
        <img alt="image" src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-top" >
        <img alt="image" src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-bottom" >
        <div class="container">
            <div class="row g-4 mb-60">
            @foreach($posts as $post)
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10">
                    <div class="single-blog-style1 wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="blog-img">
                            <a href="/seller/blog/{{ $post->categoryRelation->slog }}/{{ $post->slog }}" class="blog-date">
                                <i class="bi bi-calendar-check"></i>
                                {{ $post->created_at ? $post->created_at->format('d M, Y') : '' }}
                            </a>
                            <a href="/seller/blog/{{ $post->categoryRelation->slog }}/{{ $post->slog }}">
                                <img alt="image" src="{{ asset('public/assets/frontend/img/posts/' . ($post->imgs ?? 'default.jpg')) }}">
                            </a>
                        </div>
                        <div class="blog-content">
                            <h3 class="h5">
                                <a href="/seller/blog/{{ $post->categoryRelation->slog }}/{{ $post->slog }}">
                                    {{ \Illuminate\Support\Str::limit($post->title ?? 'Unknown Article', 50, '...') }}
                                </a>
                            </h3>
        
                            <div class="blog-meta">
                                <div class="comment">
                                    <img alt="image" src="{{ asset('public/assets/frontend/images/icons/tags.svg') }}">
                                    <a href="javascript:void(0)" class="comment">
                                        {{ $post->category ?? 0 }}
                                    </a>
                                </div>
                                <div class="author">
                                    <img alt="image" src="{{ asset('public/assets/frontend/images/blog/user.png') }}">
                                    <span class="author-name">{{ $post->author ?? '--' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        {{-- Pagination --}}
        <div class="row">
            <nav class="pagination-wrap">
                {{ $posts->links('pagination::bootstrap-5') }}
            </nav>
        </div>
        </div>
    </div>

    <!-- ===============  Hero area end=============== -->

    <!-- =============== counter-section end =============== -->
      

  <!-- About-us-counter section End --> 
@include('.frontend.seller.inc.footer')