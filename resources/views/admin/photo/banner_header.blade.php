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
                        <form class="forms-sample" method="POST"
                            action="{{ route('admin.photo.post.banner.header', $data->type) }}"
                            enctype="multipart/form-data">
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
                                        @php
                                            $thumbsize = json_decode($settings['THUMB_SIZE_BANNER_HEADER_VI']);
                                        @endphp
                                        <label for="slug">Hình ảnh</label><span>
                                            <p class="card-description">
                                                Upload (jpg, png, jpeg, gif)
                                                [{{ $thumbsize->width . 'px x ' . $thumbsize->height }}px]
                                            </p>
                                        </span>
                                        <input type="file" onchange="previewFile(this);" id="formFile"
                                            class="form-control" name="photo_vi">
                                    </div>
                                    <div class="form-group">
                                        <img src="{{ asset('public/upload/images/photo/thumb/vi/' . $data_vi->photo) }}"
                                            id="previewImage" class="form-control img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="form-group">
                                        <label for="slug">Image</label><span>
                                            @php
                                                $thumbsize = json_decode($settings['THUMB_SIZE_BANNER_HEADER_EN']);
                                            @endphp
                                            <p class="card-description">
                                                Upload (jpg, png, jpeg, gif)
                                                [{{ $thumbsize->width . 'px x ' . $thumbsize->height }}px]
                                            </p>
                                        </span>
                                        <input type="file" onchange="previewFile(this);" id="formFile1"
                                            class="form-control" name="photo_en">
                                    </div>
                                    <div class="form-group">
                                        <img src="{{ asset('public/upload/images/photo/thumb/en/' . $data_en->photo) }}"
                                            id="previewImage1" class="form-control img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
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

        function previewFile(input) {
            let file = $("#formFile1").get(0).files[0];

            if (file) {
                let reader = new FileReader();
                console.log(reader);
                reader.onload = function() {
                    $('#previewImage1').attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
