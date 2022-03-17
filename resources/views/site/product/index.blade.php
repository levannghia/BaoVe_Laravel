@php
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$urlPhoto = $protocol . $_SERVER['HTTP_HOST'] .'/public/upload/images/seoPage/thumb/'.$seoPage->photo;
@endphp
@section('PHOTO', $urlPhoto)
@extends('site.layout')
@section('SEO_title', $seoPage->title)
@section('SEO_keywords', $seoPage->keywords)
@if (isset($image->mimeType)  && isset($image->width) && isset($image->height))
@section('mimeType', $image->mimeType)
@section('width', $image->width)
@section('height', $image->height)
@endif
@section('SEO_description', $seoPage->description)
@section('content')
    <div class="content">
        <div class="container">
            <!-- Banner - menu -->

            {{-- silder --}}
          
            <!-- content -->
            <h2 class="product-new">SẢN PHẨM</h2>
            
            </p>
            <div class="row">
                @foreach ($product as $item)
                    <div class="col-md-3">
                        <div class="border-col">
                            <div class="detail-product-link">
                                <a href="{{ route('get.product.slug', $item->slug) }}"><img
                                        src="public/upload/images/product/thumb/{{ $item->photo }}" alt="" width="200px"></a>
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
            {{$product->links()}}

        </div>
    </div>

@endsection
