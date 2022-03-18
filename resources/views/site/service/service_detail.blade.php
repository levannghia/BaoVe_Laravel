@php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
$urlPhoto = $protocol . $_SERVER['HTTP_HOST'] . '/public/upload/images/service/thumb/' . $service->photo;
@endphp
@extends('site.layout')
@section('PHOTO', $urlPhoto)
@section('SEO_title', $service->title)
@section('SEO_keywords', $service->keywords)
@if (isset($image->mimeType) && isset($image->width) && isset($image->height))
    @section('mimeType', $image->mimeType)
    @section('width', $image->width)
    @section('height', $image->height)
@endif
@section('SEO_description', $service->keywords)
@section('content')
    <div class="main-content-contacts">
        <div class="container">
            <div class="tieude_giua">
                <div>{{$service->title}}</div><span></span>
            </div>
            <div class="main-content-wrapper">
                <div class="clears"></div>
                <div id="main-content" class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {!! $service->content !!}
                    </div>
                </div>
                {{-- <div class="fb-share-button" data-href="" data-layout="button_count" data-size="small"><a target="_blank" href="{{URL::current()}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div> --}}
                <div class="share">
                    <div class="fb-like" data-href="{{ URL::current() }}" data-width="" data-layout="button_count"
                        data-action="like" data-size="small" data-share="true"></div>
                    <div class="zalo-share-button" data-href="" data-oaid="579745863508352884" data-layout="1"
                        data-color="blue" data-customize="false"></div>
                </div>
                <div class="clear" style="padding-bottom: 20px;"></div>
                <div class="news-lien-quan">
                    <p style="font-style: italic; font-weight: bold; margin-bottom: 0px;">Bài viết khác:</p>
                    <ul>
                        @foreach ($service_lq as $item)
                            <?php
                            
                            $date = new DateTime($item->created_at);
                        
                            ?>
                            <li><a href="/dich-vu/{{ $item->slug }}" title="{{ $item->title }}">{{ $item->title }}</a>
                                - {{ $date->format('d/m/Y'); }}</li>
                        @endforeach
                    </ul>
                    {{$service_lq->links()}}
                </div>

            </div>
        </div>
    </div>
@endsection
