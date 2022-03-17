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
                        <form class="forms-sample" method="POST" action="{{route('admin.photo.post.photo',$data->id)}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <?php
                                if($data->type == "logo"){
                                    $thumbsize = json_decode($settings['THUMB_SIZE_LOGO']);
                                }elseif ($data->type == "favicon") {
                                    $thumbsize = json_decode($settings['THUMB_SIZE_FAVICON']);
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
                                <img src="{{asset('public/upload/images/photo/thumb/'.$data->photo)}}" id="previewImage" style="width: 120px !important;" class="form-control img-fluid" alt="">
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
    </script>
@endpush
