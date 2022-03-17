@extends('admin.layout')
@section('title', $row->title)
@section('content')

    <div class="content-wrapper">
        @include('admin.inc.message')
        <form class="forms-sample" method="POST" action="{{ route('admin.standard.update', $standard->id) }}"
            enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $row->desc }}</h4>
                            @include('admin.inc.error')
                            @csrf
                            <div class="form-group">
                                <label for="slug">Tiêu đề</label>
                                <input type="text" class="form-control" value="{{ old('title', $standard->title) }}"
                                    id="slug" name="title" placeholder="* Tiêu đề" onkeyup="changeToString()">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Mô tả</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4"
                                    name="description">{{ old('description', $standard->description) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Số thứ tự</label>
                                <input style="width: 11%;" type="text" class="form-control" name="stt" value="{{ old('stt', $standard->stt)}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Tình trạng</label>
                                <select class="js-example-basic-multiple w-100" name="status">
                                    <option value="0" {{ $standard->status == 0 ? 'selected' : '' }}>Ẩn</option>
                                    <option value="1" {{ $standard->status == 1 ? 'selected' : '' }}>Hiển thị</option>
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
                                $thumbsize = json_decode($settings['THUMB_SIZE_STANDARD']);
                                ?>
                                <label for="slug">Hình ảnh</label> <span>
                                    <p class="card-description">
                                        Upload (jpg, png, jpeg, gif)
                                        [{{ $thumbsize->width . 'px x ' . $thumbsize->height }}px]
                                    </p>
                                </span>
                                <input type="file" class="form-control" id="formFile" name="photo">
                                <img src="{{asset('public/upload/images/standard/thumb/'.$standard->photo)}}" class="form-control img-fluid"
                                    id="previewImage" class="" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
            <a href="{{ route('admin.standard.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
@endsection
@push('script')
@endpush
