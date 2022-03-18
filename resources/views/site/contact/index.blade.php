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
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 lienhe">
                        {!! $page->content !!}
                    </div>
                    <form class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 form-contact validation-contact"
                        id="form_contact">
                        {{-- <div class="alert alert-danger" role="alert">
                            
                        </div> --}}
                        @csrf
                        <div class="row">
                            <div class="input-contact col-sm-6">
                                <input type="text" class="form-control" id="ten" name="name" value="{{ old('name') }}"
                                    placeholder="Họ tên" required>
                                <div class="invalid-feedback">Vui lòng nhập họ và tên</div>
                                <p class="error_name mt-1 mb-0" style="color:#EF8D21;display:none;"></p>
                            </div>
                            <div class="input-contact col-sm-6">
                                <input type="number" class="form-control" id="dienthoai" name="phone"
                                    placeholder="Số điện thoại" required value="{{ old('phone') }}">
                                <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                                <p class="error_sdt mt-1 mb-0" style="color:#EF8D21;display:none;"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-contact col-sm-6">
                                <input type="text" class="form-control" id="diachi" name="address" placeholder="Địa chỉ"
                                    required value="{{ old('address') }}">
                                <div class="invalid-feedback">Vui lòng nhập địa chỉ</div>
                                <p class="error_address mt-1 mb-0" style="color:#EF8D21;display:none;"></p>
                            </div>
                            <div class="input-contact col-sm-6">
                                <input type="email" value="{{ old('email') }}" class="form-control" id="email"
                                    name="email" placeholder="Email" required>
                                <div class="invalid-feedback">Vui lòng nhập địa chỉ email</div>
                                <p class="error_email mt-1 mb-0" style="color:#EF8D21;display:none;"></p>
                            </div>
                        </div>
                        <div class="input-contact">
                            <input type="text" class="form-control" id="tieude" value="{{ old('note') }}" name="note"
                                placeholder="Chủ đề" required>
                            <div class="invalid-feedback">Vui lòng nhập chủ đề</div>
                            <p class="error_note mt-1 mb-0" style="color:#EF8D21;display:none;"></p>
                        </div>
                        <div class="input-contact">
                            <textarea rows="4" class="form-control-te" id="noidung" name="content" placeholder="Nội dung"
                                required>{{ old('content') }}</textarea>
                            <div class="invalid-feedback">Vui lòng nhập nội dung</div>
                            <p class="error_content mt-1 mb-0" style="color:#EF8D21;display:none;"></p>
                        </div>
                        <input type="button" class="btn btn-primary" name="submit-contact" id="btn_send" value="Gửi">
                        <input type="reset" class="btn btn-secondary" name="reset" value="Nhập lại">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="map">
        <div class="container">
            {!! $settings['MAP_IFRAME'] !!}
        </div>
    </div>
@endsection
@push('script_site')
    <script>
        $(document).ready(function() {
            $("#btn_send").click(function() {
                var _token = $('meta[name="csrf-token"]').attr('content');
                var data_form = $("#form_contact").serialize();
                $.ajax({
                    url: "{{ route('post.page.lien.he') }}",
                    type: "POST",
                    data: "_token=" + _token + "&" + data_form,
                    beforeSend: function() {
                        $(".error_name").hide();
                        $(".error_phone").hide();
                        $(".error_email").hide();
                        $(".error_address").hide();
                        $(".error_content").hide();
                        $(".error_note").hide();
                    },
                    success: function(data) {
                        console.log(data)
                        if (data.status == 1) {
                            swal("Sucessfuly, Thank you!", "We're will contact soon!",
                                "success").then((value) => {
                                if (value) {
                                    location.reload();
                                }
                                if (value == null) {
                                    location.reload();
                                }
                            });
                        } else {
                            data.error.name != undefined ? $(".error_name").html(
                                data.error.name).show() : "";
                            data.error.email != undefined ? $(".error_email").html(data.error
                                .email).show() : "";
                            data.error.address != undefined ? $(".error_address").html(data.error
                                .address).show() : "";
                            data.error.phone != undefined ? $(".error_sdt").html(data.error
                                .phone).show() : "";
                            data.error.note != undefined ? $(".error_note").html(data.error
                                .note).show() : "";
                            data.error.content != undefined ? $(".error_content").html(data.error
                                .content).show() : "";
                        }
                    },
                });
            })
        })
    </script>
@endpush
