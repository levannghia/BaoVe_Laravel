@extends('admin.layout')
@section('title', $row->title)
@section('content')
    <div class="content-wrapper">
        @include('admin.inc.message')
        <form class="forms-sample" method="POST" action="{{ route('admin.seo.page.post', $seoPage->id) }}" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $row->desc }}</h4>
                            @include('admin.inc.error')
                            @csrf
                            <div class="form-group">
                                <?php
                                $thumbsize = json_decode($settings['THUMB_SIZE_SEO_PAGE']);
                                ?>
                                <label for="slug">Hình ảnh</label> <span>
                                    <p class="card-description">
                                        Upload (jpg, png, jpeg, gif)
                                        [{{ $thumbsize->width . 'px x ' . $thumbsize->height }}px]
                                    </p>
                                </span>
                                <input type="file" class="form-control" id="formFile" name="photo"
                                    onchange="previewFile(this);">
                                <img style="width: 300px" src="{{asset('public/upload/images/seoPage/thumb/'.$seoPage->photo)}}" class="form-control img-fluid" id="previewImage" class="" alt="">
                            </div>
                            <div class="form-group">
                                <div class="seo-e" style="display: flex; justify-content: space-between;">
                                    <label for="exampleTextarea1">SEO title:</label>
                                    <div class="kytu">
                                        <input readonly type="text" name="seo_tt" size=3 maxlength=3 value="100"
                                        disabled="disabled"><span>Ký tự</span>
                                    </div>
                                </div>
                                <input type="text" class="form-control" value="{{ old('seo_title',$seoPage->title) }}"
                                    name="seo_title" onKeyDown="CountLeft(this.form.seo_title, this.form.seo_tt,100);"
                                    onKeyUp="CountLeft(this.form.seo_title, this.form.seo_tt,100);">
                            </div>
                            <div class="form-group">
                                <div class="seo-e" style="display: flex; justify-content: space-between;">
                                    <label for="exampleTextarea1">SEO keywords:</label>
                                    <div class="kytu">
                                        <input readonly type="text" name="seo_kw" size=3 maxlength=3 value="150"
                                        disabled="disabled"> <span>Ký tự</span>
                                    </div>
                                </div>
                                <input type="text" class="form-control" value="{{ old('seo_keywords',$seoPage->keywords) }}"
                                    name="seo_keywords" onKeyDown="CountLeft(this.form.seo_keywords, this.form.seo_kw,150);"
                                    onKeyUp="CountLeft(this.form.seo_keywords, this.form.seo_kw,150);">
                            </div>
                            <div class="form-group">
                                <div class="seo-e" style="display: flex; justify-content: space-between;">
                                    <label for="exampleTextarea1">SEO description</label>
                                    <div class="kytu">
                                        <input readonly type="text" name="seo_ds" size=3 maxlength=3 value="160"
                                        disabled="disabled"><span>Ký tự</span>
                                    </div>
                                </div>
                                <input type="text" class="form-control" value="{{ old('seo_description',$seoPage->description) }}"
                                    onKeyDown="CountLeft(this.form.seo_description, this.form.seo_ds,160);"
                                    onKeyUp="CountLeft(this.form.seo_description, this.form.seo_ds,160);"
                                    name="seo_description">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
        </form>
    </div>
@endsection
@push('script')
    <script>
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
        function CountLeft(field, count, max) {
            if (field.value.length > max)
                field.value = field.value.substring(0, max);
            else
                count.value = max - field.value.length;
        }
    </script>
@endpush