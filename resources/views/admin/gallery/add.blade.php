@extends('admin.layout')
@section('title', $row->title)
@section('content')

    <div class="content-wrapper">
        @include('admin.inc.message')
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $row->desc }}</h4>
                        @include('admin.inc.error')
                        <form class="forms-sample" method="POST" action="{{ route('admin.gallery.store', $product->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <?php
                                $thumbsize = json_decode($settings['THUMB_SIZE_GALLERY']);
                                ?>
                                <label for="slug">Hình ảnh (Tốt nhất là 3 hình ảnh)</label> <span>
                                    <p class="card-description">
                                        Upload (jpg, png, jpeg, gif)
                                        [{{ $thumbsize->width . 'px x ' . $thumbsize->height }}px]
                                    </p>
                                </span>
                                <input type="file"  id="formFile" class="form-control"
                                    name="photo[]" multiple>
                            </div>
                            <div class="form-group">
                                <img src="" id="previewImage" class="img-fluid" alt="">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a href="{{ route('admin.gallery.index', $product->id) }}" class="btn btn-light">Cancel</a>
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
        // function previewFile(input) {
        //     let file = $("#formFile");
        //     for (var i = 0; i < file.lenght; i++) {
        //         console.log(file..get(i).files[i]);
        //     }

        //     if (file) {
        //         let reader = new FileReader();
        //         console.log(reader);
        //         reader.onload = function() {
        //             $('#previewImage').attr("src", reader.result);
        //         }
        //         reader.readAsDataURL(file);
        //     }
        // }
    </script>
@endpush
