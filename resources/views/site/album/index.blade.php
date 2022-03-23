@php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
$urlPhoto = $protocol . $_SERVER['HTTP_HOST'] . '/public/upload/images/seoPage/thumb/' . $seoPage->photo;
@endphp
@extends('site.layout')
@section('PHOTO', $urlPhoto)
@section('SEO_title', 'Album')
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
                <div>Album</div><span></span>
            </div>
            <div class="main-content-wrapper">
                <div class="clears"></div>
                <div id="main-content" class="row">
                    {{-- data-caption="This image has a caption 1" --}}
                    @foreach ($album as $item)
                        <div class="col-md-3 criteria-option" style="margin-bottom: 20px;">
                            <a href="{{ asset('public/upload/images/photo/large/' . $item->photo) }}"
                                data-fancybox="group">
                                <img class="eeee"
                                    src="{{ asset('public/upload/images/photo/thumb/' . $item->photo) }}" />
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script_site')
    <script>
        $('[data-fancybox]').fancybox({
            // Options will go here
            buttons: [
                "zoom",
                "slideShow",
                "fullScreen",
                "thumbs",
                "close"
            ],
            thumbs: {
                autoStart: false,
                axis: 'x'
            },
            wheel: false,
            transitionEffect: "slide",
            // thumbs          : false,
            // hash            : false,
            loop: true,
            // keyboard        : true,
            toolbar: true,
            // animationEffect : false,
            // arrows          : true,
            clickContent: false
        });
    </script>
@endpush
