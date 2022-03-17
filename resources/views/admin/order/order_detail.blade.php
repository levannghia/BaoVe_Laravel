@extends('admin.layout')
@section('title', $row->title)
@section('content')
    <div class="content-wrapper">
        @include('admin.inc.message')
        {{-- <form class="forms-sample" method="POST" action="{{ route('admin.config.update') }}"> --}}
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $row->desc }}</h4>
                        @include('admin.inc.error')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slug">Họ & tên</label>
                                    <input type="text" class="form-control" value="{{ old('name', $order->name) }}"
                                        name="name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextarea1">Email</label>
                                    <input type="email" class="form-control" value="{{ old('email', $order->email) }}"
                                        name="email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextarea1">Số điện thoại</label>
                                    <input type="text" class="form-control" value="{{ old('phone', $order->phone) }}"
                                        name="phone">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextarea1">Thời gian đặt hàng</label>
                                    <input type="text" class="form-control" value="{{ $order->created_at }}"
                                        name="create">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slug">Địa chỉ</label>
                                    <input type="text" class="form-control"
                                        value="{{ $order->address . ', ' . $order->ward . ', ' . $order->quanHuyen . ', ' . $order->tinhTP }}"
                                        name="address">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextarea1">Ghi chú</label>
                                    <textarea class="form-control" id="exampleTextarea1" rows="8"
                                        name="note">{{ old('note', $order->note) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextarea1">Trạng thái đơn hàng</label>
                                    <select class="js-example-basic-multiple w-100" id="order_status" name="status"
                                        order_id="{{ $order->id }}">
                                        <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>
                                            Đang chờ xử lý</option>
                                        <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>
                                            Xác nhận</option>
                                        <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>
                                            Đang vận chuyển</option>
                                        <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>
                                            Giao hàng thành công</option>
                                        <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>
                                            Hủy đơn hàng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <form>
                        <div class="card-body">
                            <h4 class="card-title">Thông tin đơn hàng</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>#</th>
                                                    <th>Photo</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Số lượng</th>
                                                    <th>giá</th>
                                                    {{-- <th>Cập nhât</th>
                                                        <th>Trạng thái</th>
                                                        <th>Actions</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @if (isset($orderDetail))
                                                    @foreach ($orderDetail as $item)
                                                        <tr>
                                                            <th><input type="checkbox" name="check[]"
                                                                    value="{{ $item->id }}" />
                                                            </th>
                                                            <td>{{ $i++ }}</td>
                                                            <td><img src="{{asset('public/upload/images/product/thumb/'.$item->photo )}}"
                                                                    class="img-fluid" alt=""></td>
                                                            <td><a href="{{ route('admin.product.edit', $item->id) }}"
                                                                    title="Chỉnh sửa {{ $item->name }}">{{ $item->name }}</a>
                                                            </td>
                                                            <td>{{ $item->quantiti }}</td>
                                                            @if ($item->price != null)
                                                                <td> {{ number_format($item->price, 0, ',', '.') }} đ
                                                                </td>
                                                            @else
                                                                <td> <a href="tel:{{ $settings['PHONE'] }}"><span
                                                                            class="badge bg-soft-danger text-danger shadow-none">Liên
                                                                            hệ</span></a></td>
                                                            @endif


                                                            {{-- <td>
                                                                    <select class="js-example-basic-multiple w-100" id="order_status"
                                                                        name="status" order_id="{{$item->id}}">
                                                                        <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>
                                                                            Đang chờ xử lý</option>
                                                                        <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>
                                                                            Xác nhận</option>
                                                                        <option value="2" {{ $item->status == 2 ? 'selected' : '' }}>
                                                                            Đang vận chuyển</option>
                                                                        <option value="3" {{ $item->status == 3 ? 'selected' : '' }}>
                                                                            Giao hàng thành công</option>
                                                                        <option value="4" {{ $item->status == 4 ? 'selected' : '' }}>
                                                                            Hủy đơn hàng</option>
                                                                    </select>
                                                                </td> --}}
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <th scope="row"></th>
                                                        <td colspan="4"><strong>Thành tiền:</strong></td>
                                                        <td><strong>{{ number_format($order->total_price, 0, ',', '.') }}
                                                                đ</strong></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{-- <div class="btn-group">
                                    <button type="button" class="btn btn-danger btn-xs dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                            class="fe-trash-2"></i> <i class="fa fa-trash-o"></i></button>
                                    <div class="dropdown-menu" x-placement="bottom-start"
                                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 37px, 0px);">
                                        <a class="dropdown-item" href="#"
                                            onclick="javascript:checkDelBoxes($(this).closest('form').get(0), 'check[]', true);return false;"><i
                                                class="fe-check-square"></i> Tất cả</a>
                                        <a class="dropdown-item" href="#"
                                            onclick="javascript:checkDelBoxes($(this).closest('form').get(0), 'check[]', false);return false;"><i
                                                class="fe-x"></i> Hủy bỏ</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" delete-all="true"
                                            url="/admin/don-hang/delete-all" href="#"><i class="fe-trash-2"></i> Xóa</a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <button class="btn btn-outline-success" data-toggle="popover"
            data-content="Chức năng đang cập nhật">Export Excel</button>
            <a href="{{ route('admin.order.index') }}" class="btn btn-light">Cancel</a>

        {{-- <button type="submit" class="btn btn-primary mr-2">Submit</button> --}}
        {{-- </form> --}}
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $(function() {
                $('[data-toggle="popover"]').popover()
            })
            $("#order_status").change(function() {
                var status = $(this).val();
                var id = $(this).attr("order_id")
                var _token = "{{ csrf_token() }}";
                var time = $("#update_time");
                $.ajax({
                    url: "/admin/don-hang/status",
                    type: "POST",
                    data: {
                        st: status,
                        id: id,
                        _token: _token
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            swal("Sucessfuly, Thank you!", "Đơn hàng của bạn đã được cập nhật",
                                "success").then((value) => {
                                if (value) {

                                }
                                if (value == null) {

                                }
                            });
                        }
                    }
                });

            });
        });
    </script>
@endpush
