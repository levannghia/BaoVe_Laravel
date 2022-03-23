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
            <div class="main-content-wrapper">
                <div class="tieude_giua">
                    <div>{{ $page->title }}</div><span></span>
                </div>
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
                                    placeholder="{{ __('lang.fullname') }}" required>
                                <div class="invalid-feedback">Vui lòng nhập họ và tên</div>
                                <p class="error_name mt-1 mb-0" style="color:#EF8D21;display:none;"></p>
                            </div>
                            <div class="input-contact col-sm-6">
                                <input type="number" class="form-control" id="dienthoai" name="phone"
                                    placeholder="{{ __('lang.phone_number') }}" required value="{{ old('phone') }}">
                                <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                                <p class="error_sdt mt-1 mb-0" style="color:#EF8D21;display:none;"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-contact col-sm-6">
                                <input type="text" class="form-control" id="diachi" name="address"
                                    placeholder="{{ __('lang.address') }}" required value="{{ old('address') }}">
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
                                placeholder="{{ __('lang.theme') }}" required>
                            <div class="invalid-feedback">Vui lòng nhập chủ đề</div>
                            <p class="error_note mt-1 mb-0" style="color:#EF8D21;display:none;"></p>
                        </div>
                        <div class="input-contact">
                            <textarea rows="4" class="form-control-te" id="noidung" name="content" placeholder="{{ __('lang.content') }}"
                                required>{{ old('content') }}</textarea>
                            <div class="invalid-feedback">Vui lòng nhập nội dung</div>
                            <p class="error_content mt-1 mb-0" style="color:#EF8D21;display:none;"></p>
                        </div>
                        <div class="captcha" style="display: flex;">
                            <div class="input-contact" style="padding-right: 10px">
                                <input type="text" class="form-control" id="captcha" value="" name="captcha"
                                    placeholder="Captcha" required>
                                <p class="error_captcha mt-1 mb-0" style="color:#EF8D21;display:none;"></p>
                            </div>
                            <div class="img-captcha">
                                <img width="140" height="34" id="captcha_ne" src="/captcha" alt="Captcha" title="Captcha">
                            </div>
                            <div class="reset-captcha" style="padding-top: 5px; padding-left: 5px">
                                <img src="{{ asset('public/site/images/refresh.png') }}" alt="refresh captcha"
                                    title="Refresh captcha">
                            </div>
                        </div>
                        <input type="button" class="btn btn-primary" name="submit-contact" id="btn_send"
                            value="{{ __('lang.btnSubmit') }}">
                        <input type="reset" class="btn btn-secondary" name="reset" value="{{ __('lang.btnRetype') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div id="bando_footer">{!! $settings['MAP_IFRAME'] !!}</div>


@endsection
@push('script_site')
    <script>
        $(document).ready(function() {
            $('.reset-captcha').click(function() {
                $('#captcha_ne').attr("src", '/captcha?rand=' + Math.random());
            });

            $("#btn_send").click(function() {
                var _token = $('meta[name="csrf-token"]').attr('content');
                var data_form = $("#form_contact").serialize();
            
                alert(captcha_ss); 
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
                        $(".error_captcha").hide();
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
                            data.error.address != undefined ? $(".error_address").html(data
                                .error
                                .address).show() : "";
                            data.error.phone != undefined ? $(".error_sdt").html(data.error
                                .phone).show() : "";
                            data.error.note != undefined ? $(".error_note").html(data.error
                                .note).show() : "";
                            data.error.content != undefined ? $(".error_content").html(data
                                .error
                                .content).show() : "";
                            data.error.captcha != undefined ? $(".error_captcha").html(data
                                .error
                                .captcha).show() : "";
                        }
                    },
                });
            })
        })
    </script>
@endpush
