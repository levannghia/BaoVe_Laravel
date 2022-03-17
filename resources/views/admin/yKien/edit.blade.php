@extends('admin.layout')
@section('title', $row->title)
@section('content')

    <div class="content-wrapper">
        @include('admin.inc.message')
        <form class="forms-sample" method="POST" action="{{ route('admin.y.kien.update', $review->id) }}"
            enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $row->desc }}</h4>
                            @include('admin.inc.error')
                            @csrf
                            <div class="form-group">
                                <label for="slug">Tên khách hàng</label>
                                <input type="text" class="form-control" value="{{ old('name', $review->name) }}"
                                    id="slug" name="name" placeholder="* Tên khách hàng">
                            </div>
                            <div class="form-group">
                                <label for="convert_slug">Địa chỉ</label>
                                <input type="text" class="form-control" id="convert_slug" name="address"
                                    value="{{ old('address', $review->address) }}" placeholder="* Địa chỉ">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Đánh giá</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4"
                                    name="description">{{ old('description', $review->description) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Tình trạng</label>
                                <select class="js-example-basic-multiple w-100" name="status">
                                    <option value="0" {{ $review->status == 0 ? 'selected' : '' }}>Ẩn</option>
                                    <option value="1" {{ $review->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <?php
                                $thumbsize = json_decode($settings['THUMB_SIZE_REVIEW']);
                                ?>
                                <label for="slug">Hình ảnh</label> <span>
                                    <p class="card-description">
                                        Upload (jpg, png, jpeg, gif)
                                        [{{ $thumbsize->width . 'px x ' . $thumbsize->height }}px]
                                    </p>
                                </span>
                                <input type="file" class="form-control" id="formFile" name="photo">
                                <img src="{{asset('public/upload/images/yKien/thumb/'.$review->photo)}}"
                                    class="form-control img-fluid" id="previewImage" class="" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
            <a href="{{ route('admin.y.kien.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
@endsection
@push('script')
    <script>
        CKEDITOR.replace('description', {
            filebrowserBrowseUrl: '/public/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserWindowWidth: '1000',
            filebrowserWindowHeight: '700'
        })

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
