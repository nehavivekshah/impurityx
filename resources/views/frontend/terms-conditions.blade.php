@include('.frontend.inc.header')
    <div class="inner-banner">
        <div class="container">
            <h2 class="inner-banner-title wow fadeInLeft text-center" data-wow-duration="1.5s" data-wow-delay=".2s">
                Terms and Conditions
            </h2>
        </div>
    </div>
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! $output->content ?? 'Not Found' !!}
                </div>
            </div>
        </div>
    </section>
@include('.frontend.inc.footer')