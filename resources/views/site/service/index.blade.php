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
                <div>{{__('lang.service')}}</div><span></span>
            </div>
            <div class="main-content-wrapper">
                <div class="clears"></div>

                <div id="main-content" class="row">
                    {{-- <div class="col-md-6"> --}}
                    @foreach ($service as $item)
                        <div class="col-md-6">
                            <a class="main-content-a" href="/dich-vu/{{ $item->slug }}">
                                <div class="border-content-tintuc">
                                    <div class="row" style="margin-bottom: 20px;">
                                        <div class="col-md-6 content_image">
                                            <div class="img-news img-news-tintuc">
                                                <img src="public/upload/images/service/thumb/{{ $item->photo }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="text-news">
                                                <a href="/dich-vu/{{ $item->slug }}">
                                                    <h4 class="title-news title_tintuc">
                                                        {{ $item->title }}
                                                    </h4>
                                                </a>
                                                <p class="des-news" maxlength="200">
                                                    @if (strlen($item->description) > 206)
                                                    {{ substr($item->description, 0, 206) . '...' }}
                                                    @else
                                                    {{$item->description}}
                                                    @endif
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
                {{ $service->links() }}
            </div>
        </div>
    </div>

@endsection
