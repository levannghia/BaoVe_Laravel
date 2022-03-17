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
                        <form class="forms-sample" method="POST"
                            action="{{ route('admin.category.lv1.update', $category->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="slug">Tên danh mục</label>
                                <input type="text" class="form-control" value="{{ old('title', $category->title) }}"
                                    id="slug" name="title" placeholder="* Tên danh mục" onkeyup="changeToString()">
                            </div>
                            <div class="form-group">
                                <label for="convert_slug">Slug (seo)</label>
                                <input type="text" class="form-control" id="convert_slug" name="slug"
                                    value="{{ old('slug', $category->slug) }}" placeholder="* slug">
                            </div>
                            {{-- <div class="form-group">
                                <label for="exampleTextarea1">Keywords</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4"
                                    name="keywords">{{ old('keywords', $category->keywords) }}</textarea>
                            </div> --}}
                            {{-- <div class="form-group">
                                    <label for="price">Giá phòng</label>
                                    <input type="text" class="form-control" id="price" name="price"
                                        value="{{ old('price', $category->price) }}"
                                        placeholder="* Giá phòng">
                                </div> --}}
                            {{-- <div class="form-group">
                                <label for="exampleTextarea1">Mô tả</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4"
                                    name="description">{{ old('description', $category->description) }}</textarea>
                            </div> --}}
                            <div class="form-group">
                                <select class="js-example-basic-multiple w-100" name="status">
                                    <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Hiện</option>
                                    <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Ẩn</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Số thứ tự</label>
                                <input style="width: 11%;" type="text" class="form-control" name="stt"
                                    value="{{ old('stt', $category->stt) }}">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a href="{{ route('admin.category.index') }}" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('script')
        <script>
            CKEDITOR.replace('description', {
                filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
                filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserWindowWidth: '1000',
                filebrowserWindowHeight: '700'
            });

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
