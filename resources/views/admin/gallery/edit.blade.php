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
                            action="{{ route('admin.gallery.update', $gallery->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <?php
                                $thumbsize = json_decode($settings['THUMB_SIZE_GALLERY']);
                                ?>
                                <label for="slug">Hình ảnh</label> <span>
                                    <p class="card-description">
                                        Upload (jpg, png, jpeg, gif) [{{ $thumbsize->width . "px x " . $thumbsize->height }}px]
                                    </p>
                                </span>
                                <input type="file" onchange="previewFile(this);" id="formFile" class="form-control"
                                    name="photo">
                            </div>
                            <div class="form-group">
                                <img src="{{asset('public/upload/images/gallery/thumb/'. $gallery->photo)}}" id="previewImage"
                                    class="img-fluid" alt="">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a href="{{ route('admin.gallery.index', $gallery->product_id) }}"
                                class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
