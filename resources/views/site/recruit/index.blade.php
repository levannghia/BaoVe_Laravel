@php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
$urlPhoto = $protocol . $_SERVER['HTTP_HOST'] . '/public/upload/images/seoPage/thumb/' . $seoPage->photo;
@endphp
@extends('site.layout')
@section('PHOTO', $urlPhoto)
@section('SEO_title', $seoPage->title)
@section('SEO_keywords', $seoPage->keywords)
@if (isset($image->mimeType) && isset($image->width) && isset($image->height))
    @section('mimeType', $image->mimeType)
    @section('width', $image->width)
    @section('height', $image->height)
@endif
@section('SEO_description', $seoPage->description)
@section('content')
    <div class="main-content-contacts">
        <div class="container">
            <div class="tieude_giua">
                <div>Dịch vụ</div><span></span>
            </div>
            <div class="main-content-wrapper">
                <div class="clears"></div>

                <div id="main-content" class="row">
                    {{-- <div class="col-md-6"> --}}
                    @foreach ($recruit as $item)
                        <div class="col-md-6">
                            <a class="main-content-a" href="/dich-vu/{{ $item->slug }}">
                                <div class="border-content-tintuc">
                                    <div class="row" style="margin-bottom: 20px;">
                                        <div class="col-md-6 content_image">
                                            <div class="img-news img-news-tintuc">
                                                <img src="public/upload/images/recruit/thumb/{{ $item->photo }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="text-news">
                                                <a href="/tuyen-dung/{{ $item->slug }}">
                                                    <h4 class="title-news title_tintuc">
                                                        {{ $item->title }}
                                                    </h4>
                                                </a>
                                                <p class="des-news" maxlength="200">
                                                    {{ $item->description }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    {{-- </div> --}}
                </div>
                {{ $recruit->links() }}
            </div>
        </div>
    </div>

@endsection
