@php
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$urlPhoto = $protocol . $_SERVER['HTTP_HOST'] .'/public/upload/images/product/thumb/'.$product->photo;
@endphp
@extends('site.layout')
@section('PHOTO', $urlPhoto)
@section('SEO_title', $product->name)
@section('SEO_keywords', $product->keywords)
@section('mimeType', "image/jpeg")
@section('width', 960)
@section('height', 720)
@section('SEO_description', $product->content)
@section('content')
    <style>
        /* #chitiet-0 {
            display: none;
        } */

        #chitiet-1 {
            display: none;
        }

        .hien {
            padding-right: 10px !important;
            background-color: #006600;
            color: white;
            text-align: center;
            padding-left: 10px !important;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        body {
            /* font-family: Arial, Helvetica, sans-serif;
            overflow-x: hidden; */
        }

        img {
            max-width: 100%;
        }

        .preview {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        @media screen and (max-width: 996px) {
            .preview {
                margin-bottom: 20px;
            }
        }

        .preview-pic {
            -webkit-box-flex: 1;
            -webkit-flex-grow: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
        }

        .preview-thumbnail.nav-tabs {
            border: none;
            margin-top: 15px;
        }

        .preview-thumbnail.nav-tabs li {
            width: 23%;
            margin-right: 2.5%;
        }

        .preview-thumbnail.nav-tabs li img {
            max-width: 100%;
            display: block;
        }

        .preview-thumbnail.nav-tabs li a {
            padding: 0;
            margin: 0;
            cursor: pointer;
        }

        .preview-thumbnail.nav-tabs li:last-of-type {
            margin-right: 0;
        }

        .tab-content {
            overflow: hidden;
        }

        .tab-content img {
            width: 100%;
            -webkit-animation-name: opacity;
            animation-name: opacity;
            -webkit-animation-duration: .3s;
            animation-duration: .3s;
        }

        .card {
            margin-top: 0px;
            padding: 3em;
            line-height: 1.5em;
        }

        @media screen and (min-width: 997px) {
            .wrapper {
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
            }
        }

        .details {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .colors {
            -webkit-box-flex: 1;
            -webkit-flex-grow: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
        }

        .product-title,
        .price,
        .sizes,
        .colors {
            text-transform: UPPERCASE;
            font-weight: bold;
        }

        .checked,
        .price span {
            color: #ff9f1a;
        }

        .product-title,
        .rating,
        .product-description,
        .price,
        .vote,
        .sizes {
            margin-bottom: 15px;
        }

        .product-title {
            margin-top: 0;
        }

        .size {
            margin-right: 10px;
        }

        .size:first-of-type {
            margin-left: 40px;
        }

        .color {
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
            height: 2em;
            width: 2em;
            border-radius: 2px;
        }

        .color:first-of-type {
            margin-left: 20px;
        }

        .add-to-cart,
        .like {
            background: #006600;
            padding: 0.5em 0.5em;
            border: none;
            text-transform: UPPERCASE;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            -webkit-transition: background .3s ease;
            transition: background .3s ease;
        }

        .add-to-cart:hover,
        .like:hover {
            background: #014e01;
            color: #fff;
            text-decoration: none;
        }

        .not-available {
            text-align: center;
            line-height: 2em;
        }

        .not-available:before {
            font-family: fontawesome;
            content: "\f00d";
            color: #fff;
        }

        .orange {
            background: #ff9f1a;
        }

        .green {
            background: #85ad00;
        }

        .blue {
            background: #0076ad;
        }

        .tooltip-inner {
            padding: 1.3em;
        }

        .thong_tin {
            margin-top: 50px;
            padding-bottom: 5px;
            border-bottom: 1px solid #c2b9b9
        }

        @-webkit-keyframes opacity {
            0% {
                opacity: 0;
                -webkit-transform: scale(3);
                transform: scale(3);
            }

            100% {
                opacity: 1;
                -webkit-transform: scale(1);
                transform: scale(1);
            }
        }

        @keyframes opacity {
            0% {
                opacity: 0;
                -webkit-transform: scale(3);
                transform: scale(3);
            }

            100% {
                opacity: 1;
                -webkit-transform: scale(1);
                transform: scale(1);
            }
        }

    </style>
    <div class="container">
        <div class="card">
            <div class="container-fliud">
                <div class="wrapper row">
                    <div class="preview col-md-6">
                        <div class="preview-pic tab-content">
                            <div class="tab-pane active" id="pic-1"><img
                                    src="{{ asset('public/upload/images/product/thumb/' . $product->photo) }}"
                                    alt="{{ $product->name }}">
                            </div>
                            @php
                                $i = 2;
                            @endphp
                            @foreach ($gallery as $item)
                                <div class="tab-pane" id="pic-{{ $i++ }}"><img
                                        src="{{ asset('/public/upload/images/gallery/thumb/' . $item->photo) }}"
                                        alt="{{ $product->name }}">
                                </div>
                            @endforeach

                        </div>
                        <ul class="preview-thumbnail nav nav-tabs">
                            {{-- <div class="logo_menuchinh"
                                style="float:left; padding-top:5px; padding-left:10px; color:#fff; margin-left:auto; margin-right:auto; text-align=center; line-height:40px; font-size:16px;font-weight:bold;font-family:Arial">
                                HOCWEBGIARE.COM</div> --}}
                            {{-- <div class="menu-icon"><span>Menu</span></div> --}}
                            <li class="active"><a data-target="#pic-1" data-toggle="tab"><img
                                        src="{{ asset('public/upload/images/product/thumb/' . $product->photo) }}"
                                        alt="{{ $product->name }}"></a>
                            </li>
                            @php
                                $y = 2;
                            @endphp
                            @foreach ($gallery as $item)
                                <li><a data-target="#pic-{{ $y++ }}" data-toggle="tab"><img
                                            src="{{ asset('/public/upload/images/gallery/thumb/' . $item->photo) }}"
                                            alt="{{ $product->name }}"></a>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                    <div class="details col-md-6">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <div class="rating">
                            <div class="share">
                                <div class="fb-like" data-href="{{ URL::current() }}" data-width=""
                                    data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>
                                <div class="zalo-share-button" data-href="" data-oaid="579745863508352884" data-layout="1"
                                    data-color="blue" data-customize="false"></div>
                            </div>
                        </div>
                        @if (strlen($product->description) >= 600)
                        <p class="product-description">{!! substr($product->description, 0, 600) .'...' !!}</p>
                        @else
                        <p class="product-description">{!! $product->description !!}</p>
                        @endif
                        @if ($product->price != NULL)
                        <h4 class="price">{{ number_format($product->price, 0, ',', '.') }} đ</h4>
                        @else
                        {{-- <h4 class="price"><a href="tel:{{$settings['PHONE']}}">Liên hệ</a></h4> --}}
                        {{-- <br>
                        <p class="product-price">Giá: 
                            <a href="tel:{{$settings['PHONE']}}" class="price-product">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-telephone" viewBox="0 0 16 16">
                                    <path
                                        d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                </svg>
                            {{$settings['PHONE']}}</a>
                        </p> --}}
                        @endif
                        {{-- <p class="vote"><strong>91%</strong> of người mua hài lòng với sản phẩm này <strong>(87
                                bình chọn)</strong>
                        </p> --}}
                        {{-- <h5 class="sizes">Kích cỡ: <span class="size" data-toggle="tooltip"
                                title="small">s</span> <span class="size" data-toggle="tooltip"
                                title="medium">m</span> <span class="size" data-toggle="tooltip"
                                title="large">l</span> <span class="size" data-toggle="tooltip"
                                title="xtra large">xl</span>
                        </h5>
                        <h5 class="colors">Màu: <span class="color orange not-available" data-toggle="tooltip"
                                title="Not In store"></span> <span class="color green"></span> <span
                                class="color blue"></span>
                        </h5> --}}
                        <form action="{{route('save.cart')}}" method="post">
                            @csrf
                            <label for="">Số lượng:</label>
                            <input type="hidden" value="{{$product->id}}" name="product_id">
                            <input type="number" class="number-qty" style="width:50px;" value="1" name="quantiti">
                            <div class="action"> <a href="tel:{{ $settings['PHONE'] }}"> <button type="submit"
                                class="add-to-cart btn btn-default" type="button">MUA NGAY</button> </a>
                        </form>
                        <a href="tel:{{$settings['PHONE']}}" class="price-product">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-telephone" viewBox="0 0 16 16">
                                <path
                                    d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                            </svg>
                        {{$settings['PHONE']}}</a>
                            {{-- <a
                                href="http://hocwebgiare.com/" target="_blank"> <button class="like btn btn-default"
                                    type="button"><span class="fa fa-heart"></span></button> </a> --}}
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="thong_tin">
            <span class="btnXDT tablinks7 hien" onclick="chemistrys(event, 'chitiet-0')">Thông tin
                chi tiết
            </span>
            <span class="btnTCD tablinks7" style="padding-left: 10px;" onclick="chemistrys(event, 'chitiet-1')">Bình luận
            </span>
        </div>
        <hr style="color: black;">
        <br>
        <div id="chitiet-0" class="content0">
            {!! $product->description !!}
        </div>
        <div id="chitiet-1" class="content0">
            <div class="fb-comments" data-href="{{ URL::current() }}" data-width="100%" data-numposts="5"></div>
        </div>
        {{-- <div class="share">
            <div class="fb-like" data-href="{{ URL::current() }}" data-width=""
                data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>
            <div class="zalo-share-button" data-href="" data-oaid="579745863508352884" data-layout="1"
                data-color="blue" data-customize="false"></div>
        </div> --}}
        <h2 class="product-new">SẢN PHẨM CÙNG LOẠI</h2>
            
            </p>
            <div class="row">
                @foreach ($product_cate as $item)
                    <div class="col-md-3">
                        <div class="border-col">
                            <div class="detail-product-link">
                                <a href="{{ route('get.product.slug', $item->slug) }}"><img
                                        src="{{asset('public/upload/images/product/thumb/'.$item->photo)}}" alt="{{$item->name}}" width="200px"></a>
                            </div>
                            <a href="{{ route('get.product.slug', $item->slug) }}">
                                <h6 class="product-name">{{ $item->name }}</h6>
                            </a>
                            <div class="price-view">
                                @if ($item->price == null)
                                    <p class="product-price">Giá: <a href="{{ $settings['PHONE'] }}"
                                            class="contact-product">Liên
                                            hệ</a> </p>
                                @else
                                    <p class="product-price">Giá: <a href="{{ route('get.product.slug', $item->slug) }}"
                                            class="contact-product">{{ number_format($item->price, 0, ',', '.') }} đ</a>
                                    </p>
                                @endif
                                <p class="product-views">Lượt xem: {{ $item->view }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </div>
@endsection
@push('script_site')
    <script>
        $('.btnXDT').click(function() {
            $(this).addClass("hien")
            $('.btnTCD').removeClass("hien");
        })

        $('.btnTCD').click(function() {
            $(this).addClass("hien")
            $('.btnXDT').removeClass("hien");
        })

        function chemistrys(evt, cityName) {
            var i, tabcontent, tablinks;

            tabcontent = document.getElementsByClassName("content0");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks7");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
@endpush