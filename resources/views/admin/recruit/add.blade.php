@extends('admin.layout')
@section('title', $row->title)
@section('content')

    <div class="content-wrapper">
        @include('admin.inc.message')
        <form class="forms-sample" method="POST" action="{{ route('admin.recruit.store') }}" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $row->desc }}</h4>
                            @include('admin.inc.error')
                            @csrf
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                        aria-controls="home" aria-selected="true">Tiếng Việt</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                        aria-controls="profile" aria-selected="false">Tiếng Anh</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="form-group">
                                        <label for="slug">Tiêu đề</label>
                                        <input type="text" class="form-control" value="{{ old('title:vi') }}" id="slug"
                                            name="title:vi" placeholder="* Tiêu đề" onkeyup="changeToString()">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Mô tả</label>
                                        <textarea class="form-control" id="exampleTextarea1" rows="4"
                                            name="description:vi">{{ old('description:vi') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Nội dung</label>
                                        <textarea class="form-control" id="content" rows="4" name="content:vi">{{ old('content:vi') }}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="form-group">
                                        <label for="slug">Tiêu đề</label>
                                        <input type="text" class="form-control" value="{{ old('title:en') }}"
                                            name="title:en" placeholder="* Tiêu đề">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleTextarea1">Mô tả</label>
                                        <textarea class="form-control" id="exampleTextarea1" rows="4"
                                            name="description:en">{{ old('description:en') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Nội dung</label>
                                        <textarea class="form-control" id="content1" rows="4" name="content:en">{{ old('content:en') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="convert_slug">Slug (seo)</label>
                                <input type="text" class="form-control" id="convert_slug" name="slug"
                                    value="{{ old('slug') }}" placeholder="* slug">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Keywords (seo)</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4" name="keywords">{{ old('keywords') }}</textarea>
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
                                $thumbsize = json_decode($settings['THUMB_SIZE_RECRUIT']);
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
            <a href="{{ route('admin.recruit.index') }}" class="btn btn-light">Cancel</a>
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
        CKEDITOR.replace('content', {
            filebrowserBrowseUrl: '/public/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserWindowWidth: '1000',
            filebrowserWindowHeight: '700'
        });

        CKEDITOR.replace('content1', {
            filebrowserBrowseUrl: '/public/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserWindowWidth: '1000',
            filebrowserWindowHeight: '700'
        });
    </script>
@endpush
