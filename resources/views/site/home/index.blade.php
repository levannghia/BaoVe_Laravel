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
                <p>{!! substr($pageGT->content, 0, 900) !!}</p>
                <a class="xt" href="/gioi-thieu">Xem thêm</a>
            </div>
            <div class="clears"></div>
            <div class="service-blocks">
                <div class="owl-carousel owl-theme">
                    @foreach ($service as $key => $item)
                        <div class="item">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top"
                                    src="{{ asset('public/upload/images/service/thumb/' . $item->photo) }}"
                                    alt="{{ $item->title }}">
                                <div class="card-body">
                                    <p class="card-title" style="text-transform: uppercase;"><a
                                            href="#">{{ $item->title }}</a></p>
                                    <p class="card-text">{{ $item->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="box-center mt-5">
                <div class="row">
                    <div class="col-md-6 box-logo">
                        <div class="box-tintuc-head-mt">TIN TUYỂN DỤNG</div>
                        <div class="box-tintuc-ct-mt">
                            <div class="box-tintuc-ct-mt1">
                                <div class="box-tintuc-ten-mt1">
                                    <p>TUYỂN DỤNG TẠI NHẬT KHÁNH PHÁT</p>
                                </div>
                                <div class="mota-tintuc-mt">
                                    CÔNG TY NHẬT KHÁNH PHÁT là Công ty bảo vệ chuyên nghiệp, hiện nay đang thực hiện công
                                    tác bảo vệ cho một số cơ sở hoạt động kinh doanh trực thuộc Quân đội và Nhà nước nay
                                    chúng tôi có nhu cầu tuyển dụng nhân viên bảo vệ với yêu cầu và chế độ đãi ngộ như sau :

                                    I. ĐỐI TƯỢNG VÀ TIÊU CHUẨN TUYỂN DỤNG :

                                    1. Đối tượng :

                                    Là công dân Việt Nam không tiền án tiền sự. </div>
                                <a href="tuyen-dung/tuyen-dung-tai-nhat-khanh-phat-19.html">Xem thêm ...</a>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 box-logo">
                        <div class="box-tintuc-head-mt">LOGO</div>
                        <div class="box-tintuc-ct-mt">
                            <div class="doitac-tintuc">
                                <div class="owl-carousel owl-theme">
                                    @foreach ($partner as $key => $item)
                                        <div class="item">
                                            <img src="{{ asset('public/upload/images/photo/thumb/' . $item->photo) }}"
                                                alt="{{ $item->title }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <img src="{{ asset('public/site/images/bao-ve-6006.png') }}" alt="">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="banner-criteria">
            <div class="container">
                <h2 class="distance">TIÊU CHÍ SỰ LỰA CHỌN</h2>
                <p class="discription">Dịch vụ bảo vệ chuyên nghiệp nhất với đội ngũ nhân viên được đào tạo và cấp chứng
                    chỉ
                    nghiệp vụ bảo vệ. Chính sách đào tạo và giữ nhân viên gắn bó với công ty giúp chúng tôi có lực lượng bảo
                    vệ
                    chuyên nghiệp nhất</p>
                <div class="row criteria-blocks">
                    <div class="owl-carousel owl-theme">
                        @foreach ($standard as $key => $item)
                            <div class="item">
                                <div class="col-md-4 criteria-option col-6 img-flucol-6">
                                    <div class="hinh_chonct">
                                        <a href="#" ><img class="eeee" src="{{asset('public/upload/images/standard/thumb/'.$item->photo) }}" alt="GIÁ CẢ CẠNH TRANH"></a>
                                    </div>
                                    <div class="wrapper">
                                        <h4 class="third after">{{$item->title}}</h4>
                                    </div>
                                    <p class="standard-content">{{$item->description}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="video-clip">
                <h2 class="product-new">Video Clip</h2>
                <p class="sk-fml">Góc chia sẽ cẩm nang về thiết bị y tế chúng tôi gữi đến các bạn</p>
                <p style="text-align: center; margin-top: 0;"><img
                        src="{{ asset('public/site/images/border-xoan.jpg') }}" alt="">
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
            {{-- <div class="news-events">
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
            </div> --}}
        </div>
        <div class="banner-criteria banner-imgall">
            <div class="container">
                <h2 class="distance">ALBUM HÌNH ẢNH</h2>
                <div class="row" style="margin-top: 35px;">
                    <div class="col-md-3 criteria-option col-6 img-flucol-6">
                        <div class="img_all">
                            <a href="#" ><img class="eeee" src="/public/site/images/bv1.png" alt="GIÁ CẢ CẠNH TRANH"></a>
                        </div>
                    </div>
                    <div class="col-md-3 criteria-option col-6 img-flucol-6">
                        <div class="img_all">
                            <a href="#" ><img class="eeee" src="/public/site/images/bv2.png" alt="GIÁ CẢ CẠNH TRANH"></a>
                        </div>
                    </div>
                    <div class="col-md-3 criteria-option col-6 img-flucol-6">
                        <div class="img_all">
                            <a href="#" ><img class="eeee" src="/public/site/images/bv3.png" alt="GIÁ CẢ CẠNH TRANH"></a>
                        </div>
                    </div>
                    <div class="col-md-3 criteria-option col-6 img-flucol-6">
                        <div class="img_all">
                            <a href="#" ><img class="eeee" src="/public/site/images/bv4.png" alt="GIÁ CẢ CẠNH TRANH"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="bando_footer">
            <iframe src="https://www.google.com/maps/embed?pb=!1m24!1m12!1m3!1d125391.10858599901!2d106.67603522594862!3d10.851648784291584!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m9!3e6!4m3!3m2!1d10.756877399999999!2d106.6338518!4m3!3m2!1d10.950441999999999!2d106.875537!5e0!3m2!1svi!2s!4v1513755915827" frameborder="0" style="border:0" allowfullscreen=""></iframe>
        </div>

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
                        items: 3
                    }
                }
            });

            $('.doitac-tintuc .owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                dots: false,
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
                        items: 3
                    }
                }
            });

            $('.service-blocks .owl-carousel').owlCarousel({
                loop: true,
                dots: false,
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
                        items: 4
                    }
                }
            });

            // $(document).ready(function() {

            //     loadCate1();
            //     loadCate2()

            //     function loadCate1() {
            //         let id = $("[id1-cate-lv1]").attr("id1-cate-lv1")
            //         var show_product = $("#chemistry-a");

            //         $.ajax({
            //             method: "GET",
            //             url: "/category-lv1-show-products/" + id,
            //             data: {
            //                 id: id
            //             },
            //             success: function(data) {
            //                 show_product.html(data);
            //             }
            //         });
            //     }

            //     function loadCate2() {
            //         let id = $("[id2-cate-lv1]").attr("id2-cate-lv1");
            //         var show_product = $("#medical-equipment-b");

            //         $.ajax({
            //             method: "GET",
            //             url: "/category-lv1-show-products/" + id,
            //             data: {

            //                 id: id
            //             },
            //             success: function(data) {
            //                 show_product.html(data);
            //             }
            //         });
            //     }

            //     $("[category-id]").click(function() {
            //         let id = $(this).attr('category-id');
            //         var show_product = $("#chemistry-" + id);
            //         //console.log(id);
            //         //let _token = $('meta[name="csrf-token"]').attr('content');

            //         $.ajax({
            //             method: "GET",
            //             url: "{{ route('show.product.category') }}",
            //             data: {

            //                 id: id
            //             },
            //             success: function(data) {
            //                 show_product.html(data);
            //             }
            //         });
            //     });

            //     $("[category-id]").click(function() {
            //         let id = $(this).attr('category-id');
            //         var show_product = $("#medical-equipment-" + id);
            //         //console.log(id);
            //         //let _token = $('meta[name="csrf-token"]').attr('content');

            //         $.ajax({
            //             method: "GET",
            //             url: "{{ route('show.product.category') }}",
            //             data: {

            //                 id: id
            //             },
            //             success: function(data) {
            //                 show_product.html(data);
            //             }
            //         });
            //     });

            //     $("[data-id]").click(function() {
            //         $('#modal_map').modal('show');
            //         let id = $(this).attr('data-id');
            //         let _token = $('meta[name="csrf-token"]').attr('content');
            //         $(document).on('click', '.modal-close', function() {
            //             $('#my_modal').modal('hide');
            //         })
            //         $.ajax({
            //             method: "POST",
            //             url: "{{ route('show.map') }}",
            //             data: {
            //                 _token: _token,
            //                 id: id
            //             },
            //             success: function(data) {
            //                 if (data.status) {
            //                     //console.log(data);
            //                     if (data.data.map != null) {
            //                         $('.modal-body').html(data.data.map);
            //                     } else {
            //                         $('.modal-body').html("Đang cập nhật");
            //                     }
            //                 } else {
            //                     $('.modal-body').html("Đang cập nhật");
            //                 }
            //             }
            //         });
            //     });
            // })
        </script>
    @endpush
