@extends('admin.layout')
@section('title', $row->title)
@section('content')
    <div class="content-wrapper">
        @include('admin.inc.message')
        <form class="forms-sample" method="POST" action="{{ route('admin.contact.update',$contact->id) }}"
            enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $row->desc }}</h4>
                            @include('admin.inc.error')
                            @csrf
                            <div class="form-group">
                                <label for="slug">Name</label>
                                <input type="text" class="form-control" value="{{ old('name',$contact->name) }}" id="slug" name="name">
                            </div>
                            <div class="form-group">
                                <label for="price">Địa chỉ</label>
                                <input type="text" class="form-control" value="{{ old('address',$contact->address) }}" id="price"
                                    name="address">
                            </div>
                            <div class="form-group">
                                <label for="area">Số điện thoại</label>
                                <input type="text" class="form-control" value="{{ old('phone',$contact->phone) }}" id="area" name="phone">
                            </div>
                            <div class="form-group">
                                <label for="area">Email</label>
                                <input type="text" class="form-control" value="{{ old('email',$contact->email) }}" id="address" name="email">
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-5 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleTextarea1">Chủ đề</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4"
                                    name="note">{{ old('note',$contact->note) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Nội dung</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="6"
                                    name="content">{{ old('content',$contact->content) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Trạng thái</label>
                                <select class="js-example-basic-multiple w-100" name="status">
                                    <option value="1" {{ $contact->status == 1 ? 'selected' : '' }}>Xác nhận</option>
                                    <option value="0" {{ $contact->status == 0 ? 'selected' : '' }}>Chưa xác nhận</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
            <a href="{{ route('admin.nha.dat.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
@endsection
@push('script')
    <script>
        // CKEDITOR.replace('content', {
        //     filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
        //     filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        //     filebrowserWindowWidth: '1000',
        //     filebrowserWindowHeight: '700'
        // })

        function changeToNumber() {
            var price;
            price = document.getElementById('price').value
            var convert = formatNumber(price);
            console.log(convert);
            document.getElementById('price').value = convert;
        }

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        }
    </script>
@endpush
