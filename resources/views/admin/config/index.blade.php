@extends('admin.layout')
@section('title', $row->title)
@section('content')
    <div class="content-wrapper">
        @include('admin.inc.message')
        <form class="forms-sample" method="POST" action="{{ route('admin.config.update') }}">
            <button type="submit" class="btn btn-primary mr-2 mb-4">Submit</button>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $row->desc }}</h4>
                            @include('admin.inc.error')
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="slug">Số sản phẩm phân trang - trang index:</label>
                                        <input type="text" class="form-control" value="{{ old('phan_trang_product',$settings['PHAN_TRANG_PRODUCT']) }}"
                                            name="phan_trang_product">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Email:</label>
                                        <input type="email" class="form-control" value="{{ old('email', $settings['EMAIL']) }}"
                                            name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Zalo:</label>
                                        <input type="text" class="form-control" value="{{ old('zalo',$settings['ZALO']) }}" name="zalo">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Fanpage:</label>
                                        <input type="text" class="form-control" value="{{ old('fanpage',$settings['FANPAGE']) }}"
                                            name="fanpage">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="slug">Số bài viết phân trang - trang index:</label>
                                        <input type="text" class="form-control" value="{{ old('phan_trang_bai_viet',$settings['PHAN_TRANG_BAI_VIET']) }}"
                                            name="phan_trang_bai_viet">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Hotline:</label>
                                        <input type="text" class="form-control" value="{{ old('hotline',$settings['HOTLINE']) }}"
                                            name="hotline">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Tọa độ google map:</label>
                                        <textarea class="form-control" id="exampleTextarea1" rows="8"
                                            name="toa_do_gg_map">{{ old('toa_do_gg_map',$settings['MAP_TOA_DO']) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="slug">Địa chỉ:</label>
                                        <input type="text" class="form-control" value="{{ old('address',$settings['ADDRESS']) }}"
                                            name="address">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Điện thoại:</label>
                                        <input type="text" class="form-control" value="{{ old('phone',$settings['PHONE']) }}"
                                            name="phone">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Website:</label>
                                        <input type="text" class="form-control" value="{{ old('website',$settings['WEBSITE']) }}"
                                            name="website">
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="exampleTextarea1">Giới thiệu công ty:</label>
                                        <textarea class="form-control" id="exampleTextarea1" rows="8"
                                            name="gioi_thieu_CT">{{ old('gioi_thieu_CT',$settings['GIOI_THIEU_CONG_TY']) }}</textarea>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="slug">Tọa độ google map iframe: <span><a href="https://www.google.com/maps">(lấy
                                            mã nhúng)</a></span></label>
                                <textarea class="form-control" id="exampleTextarea1" rows="6"
                                    name="gg_map_iframe">{{ old('gg_map_iframe',$settings['MAP_IFRAME']) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Google analytics:</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4"
                                    name="analytics">{{ old('analytics',$settings['ANALYTICS']) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Google Webmaster Tool:</label>
                                <input type="text" class="form-control" value="{{ old('master_tool',$settings['WEB_MASTER_TOOL']) }}"
                                    name="master_tool">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Head JS:</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="6"
                                    name="head_js">{{ old('head_js',$settings['HEAD_JS']) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Tiêu đề:</label>
                                <input type="text" class="form-control" value="{{ old('title',$settings['TITLE']) }}" name="title">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Nội dung SEO</h4>
                            <div class="form-group">
                                <div class="seo-e" style="display: flex; justify-content: space-between;">
                                    <label for="exampleTextarea1">SEO title:</label>
                                    <div class="kytu">
                                        <input readonly type="text" name="seo_tt" size=3 maxlength=3 value="100"
                                        disabled="disabled"><span>Ký tự</span>
                                    </div>
                                </div>
                                <input type="text" class="form-control" value="{{ old('seo_title',$settings['SEO_TITLE']) }}"
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
                                <input type="text" class="form-control" value="{{ old('seo_keywords',$settings['SEO_KEYWORDS']) }}"
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
                                <input type="text" class="form-control" value="{{ old('seo_description',$settings['SEO_DISCRIPTION']) }}"
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
        function CountLeft(field, count, max) {
            if (field.value.length > max)
                field.value = field.value.substring(0, max);
            else
                count.value = max - field.value.length;
        }
    </script>
@endpush
