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
            <h2 class="product-new">MUA BÁN NHÀ ĐẤT</h2>
            
            </p>
            <div class="row">
                @foreach ($nhaDat as $item)
                <div class="col-md-6 real-estate">
                    <div class="cover">
                        <div class="row">
                            <div class="col-md-6 cover-row">
                                <a href="/mua-ban-nha-dat/{{$item->slug}}"><p><img src="public/upload/images/nhaDat/thumb/{{ $item->photo }}" alt="" class="img-padding"></p></a>
                            </div>
                            <div class="col-md-6 content_tintuc">
                                <div class="cover-bottom cover-bottom-nhadat">
                                    <a href="/mua-ban-nha-dat/{{$item->slug}}"><h6>{{ $item->name }}</h6></a>
                                    <div class="info info_tintuc">
                                        
                                        @if ($item->price == null)
                                        <div class="acreage">
                                            <i class="bi bi-currency-dollar"></i>
                                            <p><a href="tel:{{ $settings['PHONE'] }}" style="color: red;" href="">Liên hệ</a></p>
                                        </div>
                                        @else
                                        <div class="acreage">
                                            <i class="bi bi-currency-dollar"></i>
                                            <p style="color: red;">{{ number_format($item->price, 0, ',', '.') }} đ</p>
                                        </div>
                                        @endif
                                        <p>Diện tích: <a style="color: blue;" href="">{{ $item->area }}m<sup>2</sup></a></p>
                                    </div>
                                    <div class="acreage acre-map">
                                        <i class="bi bi-geo-alt"></i> <span data-id="{{ $item->id }}">Xem bản đồ</span>
                                    </div>
                                    
                                    @if (strlen($item->description) >= 150)
                                    
                                    <p class="des">{{ substr($item->description, 0, 150) . ' [...]' }}</p>
                                    @else
                                    <p class="des">{{$item->description}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
            {{$nhaDat->links()}}

        </div>
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
$(document).ready(function() {

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