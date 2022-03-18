@php
$logo = DB::table('photos')
    ->where('type', 'logo')
    ->first();
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
$urlLogo = $protocol . $_SERVER['HTTP_HOST'] . '/public/upload/images/photo/thumb/' . $logo->photo;
@endphp
@extends('site.layout')
@section('SEO_title', $settings['SEO_TITLE'])
@section('SEO_keywords', $settings['SEO_KEYWORDS'])
@section('PHOTO', $urlLogo)
@if (isset($image->mimeType) && isset($image->width) && isset($image->height))
    @section('mimeType', $image->mimeType)
    @section('width', $image->width)
    @section('height', $image->height)
@endif
@section('SEO_description', $settings['SEO_DISCRIPTION'])
@section('content')
    <div class="content">
        <div class="container">
            <!-- Banner - menu -->
            {{-- silder --}}
            @include('site.inc.slide')
            <!-- content -->
            <h2 class="product-new">GIỚI THIỆU VỀ CHÚNG TÔI</h2>
            <div class="pr">
                <p>{!! substr($pageGT->content,0,900) !!}</p>
                <a class="xt" href="/gioi-thieu">Xem thêm</a>
            </div>
            
            <h2 class="product-new">MUA BÁN NHÀ ĐẤT </h2>
            <p class="sk-fml">Chuyên mua bán nhà đất và kí gữi tại Sài Gòn</p>
            <p style="text-align: center; margin-top: 0;"><img src="{{ asset('public/site/images/border-xoan.jpg') }}"
                    alt="">
            </p>
            <div class="row">
                @foreach ($nhaDat as $item)
                    <div class="col-lg-3 col-md-6 real-estate">
                        <div class="cover">
                            <a href="/mua-ban-nha-dat/{{ $item->slug }}"><img
                                    src="public/upload/images/nhaDat/thumb/{{ $item->photo }}" alt=""
                                    class="img-padding"></a>
                            <div class="cover-bottom">
                                <a href="/mua-ban-nha-dat/{{ $item->slug }}">
                                    <h6>{{ $item->name }}</h6>
                                </a>
                                <div class="info">

                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewBox="0 0 235.517 235.517" style="enable-background:new 0 0 235.517 235.517;"
                                        xml:space="preserve">
                                        <g>
                                            <path style="fill:white;"
                                                d="M118.1,235.517c7.898,0,14.31-6.032,14.31-13.483c0-7.441,0-13.473,0-13.473
                                                            c39.069-3.579,64.932-24.215,64.932-57.785v-0.549c0-34.119-22.012-49.8-65.758-59.977V58.334c6.298,1.539,12.82,3.72,19.194,6.549
                                                            c10.258,4.547,22.724,1.697,28.952-8.485c6.233-10.176,2.866-24.47-8.681-29.654c-11.498-5.156-24.117-8.708-38.095-10.236V8.251
                                                            c0-4.552-6.402-8.251-14.305-8.251c-7.903,0-14.31,3.514-14.31,7.832c0,4.335,0,7.843,0,7.843
                                                            c-42.104,3.03-65.764,25.591-65.764,58.057v0.555c0,34.114,22.561,49.256,66.862,59.427v33.021
                                                            c-10.628-1.713-21.033-5.243-31.623-10.65c-11.281-5.755-25.101-3.72-31.938,6.385c-6.842,10.1-4.079,24.449,7.294,30.029
                                                            c16.709,8.208,35.593,13.57,54.614,15.518v13.755C103.79,229.36,110.197,235.517,118.1,235.517z M131.301,138.12
                                                            c14.316,4.123,18.438,8.257,18.438,15.681v0.555c0,7.979-5.776,12.651-18.438,14.033V138.12z M86.999,70.153v-0.549
                                                            c0-7.152,5.232-12.657,18.71-13.755v29.719C90.856,81.439,86.999,77.305,86.999,70.153z" />
                                        </g>
                                    </svg>
                                    @if ($item->price == null)
                                        <p><a href="tel:{{ $settings['PHONE'] }}" style="color: red;" href="">Liên hệ</a>
                                        </p>
                                    @else
                                        <p style="color: red;">{{ number_format($item->price, 0, ',', '.') }} đ</p>
                                    @endif
                                    <p>Diện tích: <a style="color: blue;" href="">{{ $item->area }}m<sup>2</sup></a></p>
                                </div>
                                <div class="acreage">
                                    <svg id="Capa_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path style="fill:white;"
                                            d="M168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2H168.3zM192 256C227.3 256 256 227.3 256 192C256 156.7 227.3 128 192 128C156.7 128 128 156.7 128 192C128 227.3 156.7 256 192 256z" />
                                    </svg> <span data-id="{{ $item->id }}">Xem bản đồ</span>
                                </div>
                                @if (strlen($item->description) >= 150)
                                    <p class="des">{{ substr($item->description, 0, 150) . '[...]' }}</p>
                                @else
                                    <p class="des">{{ $item->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    <!-- <div class="banner-criteria">
        <div class="container">
            <h2 class="distance">TIÊU CHÍ SỰ LỰA CHỌN</h2>
            <div class="row criteria-blocks">
                <div class="owl-carousel owl-theme">
                    @foreach ($standard as $key => $item)
                        <div class="item">
                            <div class="col-md-3 criteria-option col-6 img-flucol-6">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" width="200" height="200" viewBox="0 0 200 200" xml:space="preserve">
                                    <g transform="matrix(1 0 0 1 100.39 99.68)" id="l-rGmylNm8wurXbvWPUuq">
                                        <path
                                            style="stroke: rgb(0,0,0); stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                                            vector-effect="non-scaling-stroke" transform=" translate(0, 0)"
                                            d="M -99.72479 0 L 0.07492999999999483 99.64986 L 99.72479 0 L 0.07492999999999483 -99.64986 z"
                                            stroke-linecap="round" />
                                    </g>
                                    <g transform="matrix(1 0 0 1 100.17 100.34)" id="exPVaVJBm86_twJTfRsln">
                                        <path
                                            style="stroke: rgb(35,93,172); stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-opacity: 0; fill-rule: nonzero; opacity: 1;"
                                            vector-effect="non-scaling-stroke" transform=" translate(0, 0)"
                                            d="M -0.22984 -91.58249 L -92.08753999999999 -0.33670000000000755 L -0.22983999999999583 91.58248999999999 L 92.08754 -0.33670000000000755 z"
                                            stroke-linecap="round" />
                                    </g>
                                    <g transform="matrix(1.43 0 0 1.43 100.39 95.98)" id="XDewt6JbuW4lwAwmXcCht">
                                        <image class="eeee"
                                            style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                            vector-effect="non-scaling-stroke"
                                            xlink:href="public/upload/images/standard/thumb/{{ $item->photo }}" x="-25"
                                            y="-25" width="50" height="50"></image>
                                    </g>
                                </svg>
                                <div class="wrapper">
                                    <h4 class="third after">{{ $item->title }}</h4>
                                    {{-- <a class="third after" href="#">Start Centered</a> --}}
                                </div>

                                <p class="standard-content">{{ $item->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div> -->

    <div class="banner-criteria">
        <div class="container">
            <h2 class="distance">TIÊU CHÍ SỰ LỰA CHỌN</h2>
            <p class="discription">Dịch vụ bảo vệ chuyên nghiệp nhất với đội ngũ nhân viên được đào tạo và cấp chứng chỉ nghiệp vụ bảo vệ. Chính sách đào tạo và giữ nhân viên gắn bó với công ty giúp chúng tôi có lực lượng bảo vệ chuyên nghiệp nhất</p>
            <div class="row criteria-blocks">
                    <div class="col-md-4 criteria-option col-6 img-flucol-6">
                        <div class="hinh_chonct">
					        <a href="#" ><img src="/public/site/images/imgtc1.png" alt="GIÁ CẢ CẠNH TRANH"></a>
					    </div>
                        <div class="wrapper">
                            <h4 class="third after">Chính Sách Phát Triển</h4>
                        </div>
                        <p class="standard-content">Từ nhiều năm nay, chúng tôi vẫn tiếp tục nghiên cứu, phát triển và ứng dụng những cãi tiến mới để mang đến</p>
                    </div>
                    <div class="col-md-4 criteria-option col-6 img-flucol-6">
                        <div class="hinh_chonct">
					        <a href="#" ><img src="/public/site/images/imgtc2.png" alt="GIÁ CẢ CẠNH TRANH"></a>
					    </div>
                        <div class="wrapper">
                            <h4 class="third after">Chính Sách Phát Triển</h4>
                        </div>
                        <p class="standard-content">Từ nhiều năm nay, chúng tôi vẫn tiếp tục nghiên cứu, phát triển và ứng dụng những cãi tiến mới để mang đến</p>
                    </div>
                    <div class="col-md-4 criteria-option col-6 img-flucol-6">
                        <div class="hinh_chonct">
					        <a href="#" ><img src="/public/site/images/imgtc3.png" alt="GIÁ CẢ CẠNH TRANH"></a>
					    </div>
                        <div class="wrapper">
                            <h4 class="third after">Chính Sách Phát Triển</h4>
                        </div>
                        <p class="standard-content">Từ nhiều năm nay, chúng tôi vẫn tiếp tục nghiên cứu, phát triển và ứng dụng những cãi tiến mới để mang đến</p>
                    </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="video-clip">
            <h2 class="product-new">Video Clip</h2>
            <p class="sk-fml">Góc chia sẽ cẩm nang về thiết bị y tế chúng tôi gữi đến các bạn</p>
            <p style="text-align: center; margin-top: 0;"><img src="{{ asset('public/site/images/border-xoan.jpg') }}"
                    alt="">
            </p>
            <div class="row video-clip-blocks">
                <div class="owl-carousel owl-theme">
                    @foreach ($video as $key => $item)
                        <div class="item">
                            <iframe style="width: 100%;" height="250"
                                src="https://www.youtube.com/embed/{{ $item->link_youtube }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="news-events">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="news-events-title">TIN TỨC & SỰ KIỆN</h2>
                    <img src="{{ asset('public/site/images/border.jpg') }}" alt="">
                    <ul id="scroller">
                        @foreach ($news as $item)
                            <li>
                                <div class="border-content">
                                    <div class="text-news">
                                        <h4 class="title-news">
                                            <a href="/tin-tuc/{{ $item->slug }}">{{ $item->title }}</a>
                                        </h4>
                                        <p class="des-news">
                                            {{ $item->description }}
                                        </p>
                                    </div>
                                    <div class="img-news">
                                        <a href="/tin-tuc/{{ $item->slug }}"><img
                                                src="public/upload/images/news/thumb/{{ $item->photo }}"
                                                alt="{{ $item->title }}"></a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <h2 class="news-events-title">Ý KIẾN KHÁCH HÀNG</h2>
                    <img src="{{ asset('public/site/images/border.jpg') }}" alt="">
                    <div class="customer-avt">
                        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($review as $key => $item)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('public/upload/images/yKien/thumb/' . $item->photo) }}"
                                            alt="">
                                        <p class="customer-review">{!! $item->description !!}</p>
                                        <blockquote>
                                            <p class="name-customer">{{ $item->name }}</p>
                                            <p class="address">{{ $item->address }}</p>
                                        </blockquote>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- data-target="#exampleModalCenter" data-toggle="modal" --}}

    <!-- Modal -->
    <div class="modal fade" id="modal_map" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Bản đồ</h5>
                    <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script_site')
    <script>
        $('.video-clip-blocks .owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            autoplay: false,
            autoplayTimeout: 5000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 3
                }
            }
        });

        $('.criteria-blocks .owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            autoplay: false,
            autoplayTimeout: 5000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        });

        $('.pr .owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            autoplay: false,
            autoplayTimeout: 5000,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        });

        $(document).ready(function() {

            loadCate1();
            loadCate2()

            function loadCate1() {
                let id = $("[id1-cate-lv1]").attr("id1-cate-lv1")
                var show_product = $("#chemistry-a");

                $.ajax({
                    method: "GET",
                    url: "/category-lv1-show-products/"+ id,
                    data: {
                        id: id
                    },
                    success: function(data) {
                        show_product.html(data);
                    }
                });
            }

            function loadCate2() {
                let id = $("[id2-cate-lv1]").attr("id2-cate-lv1");
                var show_product = $("#medical-equipment-b");

                $.ajax({
                    method: "GET",
                    url: "/category-lv1-show-products/"+ id,
                    data: {

                        id: id
                    },
                    success: function(data) {
                        show_product.html(data);
                    }
                });
            }

            $("[category-id]").click(function() {
                let id = $(this).attr('category-id');
                var show_product = $("#chemistry-" + id);
                //console.log(id);
                //let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    method: "GET",
                    url: "{{ route('show.product.category') }}",
                    data: {

                        id: id
                    },
                    success: function(data) {
                        show_product.html(data);
                    }
                });
            });

            $("[category-id]").click(function() {
                let id = $(this).attr('category-id');
                var show_product = $("#medical-equipment-" + id);
                //console.log(id);
                //let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    method: "GET",
                    url: "{{ route('show.product.category') }}",
                    data: {

                        id: id
                    },
                    success: function(data) {
                        show_product.html(data);
                    }
                });
            });

            $("[data-id]").click(function() {
                $('#modal_map').modal('show');
                let id = $(this).attr('data-id');
                let _token = $('meta[name="csrf-token"]').attr('content');
                $(document).on('click', '.modal-close', function() {
                    $('#my_modal').modal('hide');
                })
                $.ajax({
                    method: "POST",
                    url: "{{ route('show.map') }}",
                    data: {
                        _token: _token,
                        id: id
                    },
                    success: function(data) {
                        if (data.status) {
                            //console.log(data);
                            if (data.data.map != null) {
                                $('.modal-body').html(data.data.map);
                            } else {
                                $('.modal-body').html("Đang cập nhật");
                            }
                        } else {
                            $('.modal-body').html("Đang cập nhật");
                        }
                    }
                });
            });
        })
    </script>
@endpush
