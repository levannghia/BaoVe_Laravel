@extends('admin.layout')
@section('title', $row->title)
@section('content')
    <div class="content-wrapper">
        @include('admin.inc.message')
        <form class="forms-sample" method="POST" action="{{ route('admin.nha.dat.update',$nhaDat->id) }}"
            enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $row->desc }}</h4>
                            @include('admin.inc.error')
                            @csrf
                            <div class="form-group">
                                <label for="slug">Tên dự án</label>
                                <input type="text" class="form-control" value="{{ old('name',$nhaDat->name) }}" id="slug" name="name"
                                    placeholder="* Tên sản phẩm" onkeyup="changeToString()">
                            </div>
                            <div class="form-group">
                                <label for="convert_slug">Slug (seo)</label>
                                <input type="text" class="form-control" id="convert_slug" name="slug"
                                    value="{{ old('slug',$nhaDat->slug) }}" placeholder="* slug">
                            </div>
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input type="text" class="form-control" value="{{ old('price',$nhaDat->price) }}" id="price"
                                    name="price" placeholder="Giá sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="area">Diện tích</label>
                                <input type="text" class="form-control" value="{{ old('area',$nhaDat->area) }}" id="area" name="area"
                                    placeholder=" 200x200">
                            </div>
                            <div class="form-group">
                                <label for="area">Địa chỉ</label>
                                <input type="text" class="form-control" value="{{ old('address',$nhaDat->address) }}" id="address" name="address"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Mô tả tóm tắt</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4"
                                    name="description">{{ old('description',$nhaDat->description) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Nội dung</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="6"
                                    name="content">{{ old('content',$nhaDat->content) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleTextarea1">Keywords (seo)</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4"
                                    name="keywords">{{ old('keywords',$nhaDat->keywords) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Bản đồ</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4"
                                    name="map">{{ old('map',$nhaDat->map) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Hiển thị</label>
                                <select class="js-example-basic-multiple w-100" name="status">
                                    <option value="1" {{ $nhaDat->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                    <option value="0" {{ $nhaDat->status == 0 ? 'selected' : '' }}>Ẩn</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <?php
                                $thumbsize = json_decode($settings['THUMB_SIZE_NHA_DAT']);
                                ?>
                                <label for="slug">Hình ảnh</label> <span>
                                    <p class="card-description">
                                        Upload (jpg, png, jpeg, gif)
                                        [{{ $thumbsize->width . 'px x ' . $thumbsize->height }}px]
                                    </p>
                                </span>
                                <input type="file" class="form-control" id="formFile" name="photo"
                                    onchange="previewFile(this);">
                                <img src="{{asset('public/upload/images/nhaDat/thumb/'.$nhaDat->photo)}}" class="form-control img-fluid" id="previewImage" class="" alt="">
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
        CKEDITOR.replace('content', {
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
