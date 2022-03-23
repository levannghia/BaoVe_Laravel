@php
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$urlPhoto = $protocol . $_SERVER['HTTP_HOST'] .'/public/upload/images/seoPage/thumb/'.$seoPage->photo;
@endphp
@extends('site.layout')
@section('PHOTO', $urlPhoto)
@section('SEO_title', $seoPage->title)
@section('SEO_keywords', $seoPage->keywords)
@if (isset($image->mimeType)  && isset($image->width) && isset($image->height))
@section('mimeType', $image->mimeType)
@section('width', $image->width)
@section('height', $image->height)
@endif
@section('SEO_description', $seoPage->description)
@section('content')
    <div class="main-content-contacts">
        <div class="container">
            <div class="main-content-wrapper">
                <div class="tieude_giua"><div>{{$page->title}}</div><span></span></div>
                <div class="clears"></div>
                <div id="main-content" class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
            <div class="share">
                <div class="fb-like" data-href="{{ URL::current() }}" data-width="" data-layout="button_count"
                    data-action="like" data-size="small" data-share="true"></div>
                <div class="zalo-share-button" data-href="" data-oaid="579745863508352884" data-layout="1"
                    data-color="blue" data-customize="false"></div>
            </div>
            <div class="clear" style="padding-bottom: 20px;"></div>
        </div>
    </div>
    {{-- <div class="map">
        <div class="container">
            {!! $settings['MAP_IFRAME'] !!}
        </div>
    </div> --}}
@endsection

