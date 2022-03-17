@extends('admin.layout')
@section('title', $row->title)
@section('content')
    <div class="content-wrapper">
        @include('admin.inc.message')
        <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $row->desc }}</h4>
                        @include('admin.inc.error')
                        <form class="forms-sample" method="POST" action="{{ route('admin.photo.store', $getType) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if ($getType == "partner")
                            <div class="form-group">
                                <label for="slug">Tiêu đề</label>
                                <input type="text" class="form-control" value="{{ old('title') }}" id="slug" name="title"
                                    placeholder="* Tiêu đề">
                            </div>
                            @elseif ($getType == "social-top" || $getType == "social-footer")
                            <div class="form-group">
                                <label for="slug">Tiêu đề</label>
                                <input type="text" class="form-control" value="{{ old('title') }}" id="slug" name="title"
                                    placeholder="* Tiêu đề">
                            </div>
                            <div class="form-group">
                                <label for="slug">Mô tả</label>
                                <input type="text" class="form-control" value="{{ old('description') }}" id="slug" name="description"
                                    placeholder="* Mô tả">
                            </div>
                            <div class="form-group">
                                <label for="slug">Link</label>
                                <input type="text" class="form-control" value="{{ old('link') }}" id="slug" name="link"
                                    placeholder="* Link mạng xã hội">
                            </div>
                            @endif
                            <div class="form-group">
                                <?php
                                if($getType == "slide"){
                                    $thumbsize = json_decode($settings['THUMB_SIZE_SLIDER']);
                                }elseif ($getType == "partner") {
                                    $thumbsize = json_decode($settings['THUMB_SIZE_PARTNER']);
                                }elseif ($getType == "social-top") {
                                    $thumbsize = json_decode($settings['THUMB_SIZE_SOCIAL_TOP']);
                                }elseif ($getType == "social-footer") {
                                    $thumbsize = json_decode($settings['THUMB_SIZE_SOCIAL_FOOTER']);
                                }
                                ?>
                                <label for="slug">Hình ảnh</label><span>
                                    <p class="card-description">
                                        Upload (jpg, png, jpeg, gif)
                                        [{{ $thumbsize->width . 'px x ' . $thumbsize->height }}px]
                                    </p>
                                </span>
                                <input type="file" onchange="previewFile(this);" id="formFile" class="form-control"
                                    name="photo">
                            </div>
                            <div class="form-group">
                                <img src="" id="previewImage" class="form-control img-fluid" alt="">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Số thứ tự</label>
                                <input style="width: 11%;" type="text" class="form-control" name="stt"
                                    value="{{ old('stt', 1) }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Hiển thị</label>
                                <select class="js-example-basic-multiple w-100" name="status">
                                    <option value="1">Hiển thị</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a href="{{ route('admin.photo.index', $getType) }}" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        //hien thi anh truoc khi update
        function previewFile(input) {
            let file = $("#formFile").get(0).files[0];

            if (file) {
                let reader = new FileReader();
                console.log(reader);
                reader.onload = function() {
                    $('#previewImage').attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
