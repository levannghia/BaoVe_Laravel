@extends('admin.layout')
@section('title', $row->title)
@section('content')

    <div class="content-wrapper">
        @include('admin.inc.message')
        <form class="forms-sample" method="POST" action="{{ route('admin.y.kien.store') }}"
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
                                <input type="text" class="form-control" value="{{ old('name') }}" id="slug" name="name"
                                    placeholder="* Tên khách hàng">
                            </div>
                            <div class="form-group">
                                <label for="convert_slug">Địa chỉ</label>
                                <input type="text" class="form-control" id="convert_slug" name="address"
                                    value="{{ old('address') }}" placeholder="* Địa chỉ">
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleTextarea1">Đánh giá</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4"
                                    name="description">{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Hiển thị</label>
                                <select class="js-example-basic-multiple w-100" name="status">
                                    <option value="1">Hiển thị</option>
                                    <option value="0">Ẩn</option>
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
                                <input type="file" class="form-control" id="formFile" name="photo"
                                    onchange="previewFile(this);">
                                <img src="" class="form-control img-fluid" id="previewImage" class="" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
            <a href="{{ route('admin.product.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
@endsection
@push('script')
    <script>
        //hien thi anh truoc khi update
        function previewFile(input) {
            let file = $("#formFile").get(0).files[0];
            // console.log(file);
            if (file) {
                let reader = new FileReader();
                console.log(reader);
                reader.onload = function() {
                    $('#previewImage').attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
        CKEDITOR.replace('description', {
            filebrowserBrowseUrl: '/public/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserWindowWidth: '1000',
            filebrowserWindowHeight: '700'
        });
    </script>
@endpush
