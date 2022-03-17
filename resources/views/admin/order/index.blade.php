@extends('admin.layout')
@section('title', $row->title)
@section('content')
    <div class="content-wrapper">
        @include('admin.inc.message')
        <div class="card">
            <form>
                <div class="card-body">
                    <h4 class="card-title">{{ $row->desc }}</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>#</th>
                                            <th>Mã đơn hàng</th>
                                            <th>Name</th>
                                            <th>Thành tiền</th>
                                            <th>Ngày đặt</th>
                                            <th>Cập nhât</th>
                                            <th>Trạng thái</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @if (isset($order))
                                            @foreach ($order as $item)
                                                <tr>
                                                    <th><input type="checkbox" name="check[]" value="{{ $item->id }}" />
                                                    </th>
                                                    <td>{{ $i++ }}</td>
                                                    <td><a href="{{ route('admin.order.edit', $item->id) }}"
                                                            title="Chỉnh sửa {{ $item->ma_donhang }}">{{ $item->ma_donhang }}</a>
                                                    </td>
                                                    <td>{{ $item->name }}</td>
                                                    <td> {{ number_format($item->total_price, 0, ',', '.') }} đ</td>
                                                    <td>{{ $item->created_at->diffForHumans() }}</td>
                                                    <td id="update_time">{{ $item->updated_at->diffForHumans() }}</td>
                                                    <td>
                                                        <select class="js-example-basic-multiple w-80" id="order_status"
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
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                                id="dropdownMenuIconButton6" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <i class="mdi mdi-settings"></i>
                                                            </button>
                                                            <div class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuIconButton6"
                                                                x-placement="bottom-start"
                                                                style="position: absolute; transform: translate3d(0px, 46px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                <h6 class="dropdown-header">Settings</h6>
                                                                {{-- <a class="dropdown-item" href="#" style="color: #5646ff">
                                                                    <i class="fa fa-pencil"></i> Xuất file Excel</a> --}}
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.order.edit', $item->id) }}"
                                                                    style="color: rgb(197, 197, 16)"><i
                                                                    class="fa fa-eye"> </i> Xem đơn hàng</a>
                                                                <a class="dropdown-item" data-id="{{ $item->id }}"
                                                                    href="#" style="color: rgb(248, 21, 21)"
                                                                    data-name="{{ $item->title }}"><i
                                                                        class="fa fa-trash-o"></i>
                                                                    Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fe-trash-2"></i> <i
                                    class="fa fa-trash-o"></i></button>
                            <div class="dropdown-menu" x-placement="bottom-start"
                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 37px, 0px);">
                                <a class="dropdown-item" href="#"
                                    onclick="javascript:checkDelBoxes($(this).closest('form').get(0), 'check[]', true);return false;"><i
                                        class="fe-check-square"></i> Tất cả</a>
                                <a class="dropdown-item" href="#"
                                    onclick="javascript:checkDelBoxes($(this).closest('form').get(0), 'check[]', false);return false;"><i
                                        class="fe-x"></i> Hủy bỏ</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" delete-all="true" url="/admin/don-hang/delete-all"
                                    href="#"><i class="fe-trash-2"></i> Xóa</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {

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
                           time.html(data.time);
                        }
                    }
                });

            });

            $("[data-id]").click(function() {
                let id = $(this).attr("data-id");
                let name = $(this).attr("data-name");
                swal({
                        title: "Are you sure?",
                        text: "Bạn có chắc muốn xóa đơn hàng: " + name,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            swal("Xóa thành công đơn hàng này", {
                                icon: "success",
                            });
                            $.ajax({
                                url: "/admin/don-hang/delete/" + id,
                                type: "GET",
                                data: {
                                    id: id
                                },
                                success: function(data) {
                                    if (data.status == 1) {

                                        window.location.reload();
                                    }
                                }
                            });
                        } else {
                            // swal("Bấm OK để trở lại");
                        }
                    });
            })
        })
    </script>
@endpush
