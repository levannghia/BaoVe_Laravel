@extends('admin.layout')
@section('title', $row->title)
@section('content')
    <div class="content-wrapper">
        @include('admin.inc.message')

        <form class="forms-sample" method="POST" action="{{ route('admin.photo.update', $data->id) }}"
            enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $row->desc }}</h4>
                            @include('admin.inc.error')
                            @csrf
                            @if ($data->type == 'partner')
                                <div class="form-group">
                                    <label for="slug">Tiêu đề</label>
                                    <input type="text" class="form-control" value="{{ old('title', $data->title) }}"
                                        id="slug" name="title" placeholder="* Tiêu đề">
                                </div>
                            @elseif ($data->type == 'social-top' || $data->type == 'social-footer')
                                <div class="form-group">
                                    <label for="slug">Tiêu đề</label>
                                    <input type="text" class="form-control" value="{{ old('title', $data->title) }}"
                                        id="slug" name="title" placeholder="* Tiêu đề">
                                </div>
                                <div class="form-group">
                                    <label for="slug">Mô tả</label>
                                    <input type="text" class="form-control" value="{{ old('description',$data->description) }}" id="slug" name="description"
                                        placeholder="* Mô tả">
                                </div>
                                <div class="form-group">
                                    <label for="slug">Link</label>
                                    <input type="text" class="form-control" value="{{ old('link', $data->link) }}"
                                        id="slug" name="link" placeholder="* Link mạng xã hội">
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="exampleTextarea1">Số thứ tự</label>
                                <input style="width: 11%;" type="text" class="form-control" name="stt"
                                    value="{{ old('stt', $data->stt) }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Hiển thị</label>
                                <select class="js-example-basic-multiple w-100" name="status">
                                    <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                    <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Ẩn</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a href="{{ route('admin.photo.index', $data->type) }}" class="btn btn-light">Cancel</a>

                        </div>
                    </div>
                </div>
                <div class="col-md-5 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <?php
                                if ($data->type == 'slide') {
                                    $thumbsize = json_decode($settings['THUMB_SIZE_SLIDER']);
                                } elseif ($data->type == 'partner') {
                                    $thumbsize = json_decode($settings['THUMB_SIZE_PARTNER']);
                                } elseif ($data->type == 'social-top') {
                                    $thumbsize = json_decode($settings['THUMB_SIZE_SOCIAL_TOP']);
                                } elseif ($data->type == 'social-footer') {
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
                                <img style="width: 100% !important;" src="{{asset('public/upload/images/photo/thumb/'.$data->photo)}}"
                                    id="previewImage" class="form-control img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
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
