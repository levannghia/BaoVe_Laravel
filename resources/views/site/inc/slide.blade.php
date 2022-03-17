
<div class="row row-slide">
    <div class="col-md-12 row-right">
        <div class="owl-carousel owl-theme">
            @foreach ($slider as $key => $item)
                <div class="item">
                    <img src="{{ asset('public/upload/images/photo/thumb/' . $item->photo) }}" class="d-block" alt="...">
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('script_site')
    <script>
        $('.row-right .owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            // animateOut: 'slideOutDown',
            animateOut: 'fadeOut',
            // animateIn: 'flipInX',
            autoplay: true,
            autoplayTimeout: 3000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    </script>
@endpush