<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        
        {{-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false"
                aria-controls="form-elements">
                <i class="mdi mdi-view-headline menu-icon"></i>
                <span class="menu-title">Quản lý danh mục</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.category.lv1.index')}}">Danh mục cấp 1</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.category.index')}}">Danh mục cấp 2</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.product.index')}}">Sản phẩm</a></li>
                </ul>
            </div>
        </li> --}}
        
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.order.index')}}">
                <i class="mdi mdi-layers menu-icon"></i>
                <span class="menu-title">Dịch vụ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-advanced" aria-expanded="false"
                aria-controls="ui-advanced">
                <i class="mdi mdi-pencil-box-outline menu-icon"></i>
                <span class="menu-title">Quản lý bài viết</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-advanced">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link"
                            href="{{route('admin.news.index')}}">Tin tức</a></li>
                            <li class="nav-item"> <a class="nav-link"
                                href="{{route('admin.y.kien.index')}}">Ý kiến khách hàng</a></li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{route('admin.video.index')}}">Video</a></li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{route('admin.standard.index')}}">Tiêu chí</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.order.index')}}">
                <i class="mdi mdi-bell menu-icon"></i>
                <span class="menu-title">Quản lý đơn hàng</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false"
                aria-controls="charts">
                <i class="mdi mdi-chart-pie menu-icon"></i>
                <span class="menu-title">Quản lý trang tĩnh</span>
                <i class="menu-arrow"></i>
            </a>
            @php
                $page = DB::table('pages')->orderBy('id','DESC')->get();
            @endphp
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    @foreach ($page as $item)
                    <li class="nav-item"> <a class="nav-link" href="/admin/page/{{$item->slug}}">{{$item->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false"
                aria-controls="tables">
                <i class="mdi mdi-image menu-icon"></i>
                <span class="menu-title">Quản lý hình ảnh</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('admin.photo.logo')}}">Logo</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('admin.photo.favicon')}}">Favicon</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/admin/photo/slide">Slideshow</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/admin/photo/partner">Đối tác</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/admin/photo/social-top">Mạng xã hội top</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/admin/photo/social-footer">Mạng xã hội footer</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="mdi mdi-checkbox-blank-circle menu-icon"></i>
                <span class="menu-title">Quản lý trang SEO</span>
                <i class="menu-arrow"></i>
            </a>
            @php
                $seo_page = DB::table('seo_pages')->orderBy('id','DESC')->get();
            @endphp
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    @foreach ($seo_page as $item)
                    <li class="nav-item"> <a class="nav-link" href="/admin/seo-page/{{$item->type}}">{{$item->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.config.index')}}">
                <i class="fa fa-gears menu-icon"></i>
                <span class="menu-title">Thiết lập thông tin</span>
            </a>
        </li>
    </ul>
</nav>
