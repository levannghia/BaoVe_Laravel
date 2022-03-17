@php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
$urlPhoto = $protocol . $_SERVER['HTTP_HOST'] . '/public/upload/images/seoPage/thumb/' . $seoPage->photo;
@endphp
@extends('site.layout')
@section('PHOTO', $urlPhoto)
@section('SEO_title', 'Giỏ hàng')
@section('SEO_keywords', $seoPage->keywords)
@if (isset($image->mimeType) && isset($image->width) && isset($image->height))
    @section('mimeType', $image->mimeType)
    @section('width', $image->width)
    @section('height', $image->height)
@endif
@section('SEO_description', $seoPage->description)
@section('content')

    <div class="container mb-5">
        <h2 class="product-new">GIỎ HÀNG</h2>
        
        <form id="form_check_out">
            <div class="row">

                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table tab-cart">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Hình ảnh</th>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $item)
                                        <tr>
                                            <th scope="row">
                                                <input type="text" id-pr="{{ $item->id }}"
                                                    data-id="cart-qty-{{ $item->id }}" row-id="{{ $item->rowId }}"
                                                    class="text-qty" value="{{ $item->qty }}">
                                                <p class="error_qty_{{ $item->id }} mt-1 mb-0"
                                                    style="color:rgb(238 44 12);display:none;">
                                                </p>
                                            </th>
                                            <td class="img-cart">
                                                <img src="public/upload/images/product/thumb/{{ $item->options->image }}"
                                                    alt="">
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            @if ($item->price != 0)
                                                <td class="price-product-cart">{{ number_format($item->price, 0, ',', '.') }} đ</td>
                                            @else
                                                <td class="price-product-cart">Liên hệ</td>
                                            @endif
                                            <td>
                                                <a onclick="return confirm('Bạn muốn xóa sản phẩm này ra khỏi giỏ hàng?')"
                                                    type="button" class="btn btn-danger btn-delete"
                                                    href="/delete-cart/{{ $item->rowId }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                        id="svg-delete">
                                                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path
                                                            d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128H416L394.8 466.1z" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="summary col-md-12">
                            <dl class="subtotal">
                                <dt>Subtotal</dt>
                                <dd id="cart-total">{{ Cart::subtotal() }} đ</dd>
                                <dt><a href="/taxes">Estimated Taxes & Fees</a></dt>
                                <dd>0 đ</dd>
                            </dl>
                            <dl class="total bg-ani">
                                <dt>Total</dt>
                                <dd>{{ Cart::subtotal() }} đ</dd>
                            </dl>
                            <div class="payment">
                                {{-- <a id="btn_checkout" href="#">Đặt hàng</a> --}}
                                <input id="btn_checkout" type="button" class="btn btn-outline-success" value="ĐẶT HÀNG"
                                    style="float: right;
                                            padding-right: 20px;
                                            text-transform: uppercase;">
                                <h4 class="headline-primary">Check out</h3>
                                    {{-- <div class="ux-card">
                                    <a href="/payment/{id}"><img src="https://img1.wsimg.com/fos/react/sprite.svg#visa" height="32"
                                            width="50" /> John Doe</a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">


                    @csrf
                    <div class="col-md-12">

                        <div class="mb-2">
                            <label for="exampleFormControlInput1" class="form-label">Họ và tên</label>
                            <input type="text" name="name" class="form-control" id="exampleFormControlInput1"
                                placeholder="" value="{{old('name')}}" required>
                            <p class="error_name mt-1 mb-0" style="color:rgb(238 44 12);display:none;"></p>
                        </div>
                        <div class="mb-2">
                            <label for="exampleFormControlInput1" class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" id="exampleFormControlInput1"
                                placeholder="" value="{{old('phone')}}" required>
                            <p class="error_phone mt-1 mb-0" style="color:rgb(238 44 12);display:none;"></p>
                        </div>
                        <div class="mb-2">
                            <label for="exampleFormControlInput1" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="exampleFormControlInput1"
                                placeholder="" value="{{old('email')}}" required>
                            <p class="error_email mt-1 mb-0" style="color:rgb(238 44 12);display:none;"></p>
                        </div>
                        <div class="mb-2">
                            <label for="exampleFormControlInput1" class="form-label">Địa chỉ</label>
                            <input type="text" name="address" class="form-control" id="exampleFormControlInput1"
                                placeholder="Số nhà, đường" value="{{old('address')}}" required>
                            <p class="error_address mt-1 mb-0" style="color:rgb(238 44 12);display:none;"></p>
                        </div>
                        <div class="mb-2">
                            <label for="exampleFormControlInput1" class="form-label">Tỉnh - Thành phố</label>
                            <select id="tinh_tp" name="tinh_tp" class="form-select form-control"
                                aria-label="Default select example">
                                <option value="">Mời bạn chọn tỉnh thành phố</option>
                                @foreach ($tinh_tp as $item)
                                    <option data-tp="{{ $item->matp }}" value="{{ $item->matp }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="error_tinh_tp mt-1 mb-0" style="color:rgb(238 44 12);display:none;"></p>
                        </div>
                        <div class="mb-2">
                            <label for="exampleFormControlInput1" class="form-label">Quận - Huyện</label>
                            <select name="quanHuyen" id="quanHuyen" class="form-select form-control"
                                aria-label="Default select example">
                            </select>
                            <p class="error_quanh_huyen mt-1 mb-0" style="color:rgb(238 44 12);display:none;"></p>
                        </div>
                        <div class="mb-2">
                            <label for="exampleFormControlInput1" class="form-label">Phường - Xã</label>
                            <select name="phuongXa" id="phuongXa" class="form-select form-control"
                                aria-label="Default select example">
                            </select>
                            <p class="error_phuong_xa mt-1 mb-0" style="color:rgb(238 44 12);display:none;"></p>
                        </div>
                        <div class="mb-2">
                            <label for="exampleFormControlTextarea1" class="form-label">Ghi chú</label>
                            <textarea name="note" class="form-control" id="exampleFormControlTextarea1"
                                rows="4">{{old('note')}}</textarea>
                            <p class="error_note mt-1 mb-0" style="color:rgb(238 44 12);display:none;"></p>
                        </div>
                    </div>


                </div>


            </div>
        </form>
    </div>

@endsection
@push('script_site')
    <script>
        $(document).ready(function() {

            $("#btn_checkout").click(function() {
                var _token = $('meta[name="csrf-token"]').attr('content');
                var data_form = $("#form_check_out").serialize();
                $.ajax({
                    url: "{{ route('check.out') }}",
                    type: "POST",
                    data: "_token=" + _token + "&" + data_form,
                    beforeSend: function() {
                        $(".error_name").hide();
                        $(".error_phone").hide();
                        $(".error_email").hide();
                        $(".error_address").hide();
                        $(".error_tinh_tp").hide();
                        $(".error_quan_huyen").hide();
                        $(".error_phuong_xa").hide();
                        $(".error_note").hide();
                    },
                    success: function(data) {
                        console.log(data)
                        if (data.status == 1) {
                            swal("Đặt hàng thành công!", "Cảm ơn bạn đã tin tưởng lựa chọn chúng tôi!",
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
                            data.error.phone != undefined ? $(".error_phone").html(data.error
                                .phone).show() : "";
                            data.error.note != undefined ? $(".error_note").html(data.error
                                .note).show() : "";
                            data.error.tinh_tp != undefined ? $(".error_tinh_tp").html(data
                                .error.tinh_tp).show() : "";
                            data.error.quanHuyen != undefined ? $(".error_quanh_huyen").html(data
                                .error.quanHuyen).show() : "";
                            data.error.phuongXa != undefined ? $(".error_phuong_xa").html(data
                                .error.phuongXa).show() : "";
                        }
                    },
                });
            })

            $('#tinh_tp').change(function() {
                var id = $(this).val();
                var _token = "{{ csrf_token() }}";
                var qh = $("#quanHuyen");
                $.ajax({
                    method: "GET",
                    url: "/quan-huyen",
                    data: {
                        maTp: id,
                        _token: _token
                    },
                    success: function(data) {
                        //console.log(data);
                        qh.html(data);
                    }
                });
            });

            $(document).on('change', '#quanHuyen', function() {
                var id = $(this).val();
                var _token = "{{ csrf_token() }}";
                var px = $("#phuongXa");
                $.ajax({
                    method: "GET",
                    url: "/phuong-xa",
                    data: {
                        maQh: id,
                        _token: _token
                    },
                    success: function(data) {
                        //console.log(data);
                        px.html(data);
                    }
                });
            });

            $('[data-id]').keyup(function() {
                var qty = $(this).val();
                var rowId = $(this).attr("row-id");
                var id = $(this).attr("id-pr");
                var _token = "{{ csrf_token() }}";

                if (qty != "") {
                    $.ajax({
                        method: "POST",
                        url: "{{ route('update.cart') }}",
                        data: {
                            rowId: rowId,
                            qty: qty,
                            _token: _token
                        },
                        beforeSend: function() {
                            $(".error_qty_" + id).hide();
                        },
                        success: function(data) {
                            if (data.status == 1) {
                                swal("Sucessfuly, Thank you!", "Cập nhật giỏ hàng thành công",
                                    "success").then((value) => {
                                    if (value) {
                                        location.reload();
                                    }
                                    if (value == null) {
                                        location.reload();
                                    }
                                });
                            } else {
                                data.error.qty != undefined ? $(".error_qty_" + id).html(
                                    data.error.qty).show() : "";
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
