@extends('admin.layout')
@section('title', $row->title)
@section('content')
    <div class="content-wrapper">
        @include('admin.inc.message')
        <form class="forms-sample" method="POST" action="{{ route('admin.page.post', $page->id) }}">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $row->desc }}</h4>
                            @include('admin.inc.error')
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
                                    @if ($page->slug != 'footer')
                                        <div class="form-group">
                                            <label for="slug">Tiêu đề</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('title:vi', $page_vi->title) }}" id="slug" name="title:vi"
                                                placeholder="* Tiêu đề" onkeyup="changeToString()">
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Nội dung</label>
                                        <textarea class="form-control" id="content" rows="8"
                                            name="content:vi">{{ old('content:vi', $page_vi->content) }}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    @if ($page->slug != 'footer')
                                        <div class="form-group">
                                            <label for="slug">Tiêu đề</label>
                                            <input type="text" class="form-control" name="title:en"
                                                value="{{ old('title:en', $page_en->title) }}" id="slug"
                                                placeholder="* Tiêu đề" onkeyup="changeToString()">
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Nội dung</label>
                                        <textarea class="form-control" id="content1" rows="8"
                                            name="content:en">{{ old('content:en', $page_en->content) }}</textarea>
                                    </div>
                                </div>
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
        CKEDITOR.replace('content', {
            filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserWindowWidth: '1000',
            filebrowserWindowHeight: '700'
        });

        CKEDITOR.replace('content1', {
            filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserWindowWidth: '1000',
            filebrowserWindowHeight: '700'
        });
    </script>
@endpush
