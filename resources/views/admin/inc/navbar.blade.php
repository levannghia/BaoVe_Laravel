<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
            <a class="navbar-brand brand-logo" href="/admin"><img style="height: 110px; width:158px;" src="{{asset('public/dashboard/images/sotagroup.png')}}"
                    alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="/admin"><img src="{{asset('public/dashboard/images/sotagroup.png')}}"
                    alt="logo"></a>
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item d-none d-lg-block">
                <h4 class="mb-0">ADMIN</h4>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-search position-relative">
                <a class="nav-link d-flex justify-content-center align-items-center" target="_blank" title="Quay về trang chủ" id="navbarSearchButton"
                    href="/">
                    <i class="fa fa-home mx-0"></i>
                </a>
                <input type="text" class="form-control" placeholder="Search..." id="navbarSearchInput">
            </li>
            <li class="nav-item dropdown">
                <a title="Liên hệ" class="nav-link count-indicator d-flex justify-content-center align-items-center"
                    id="notificationDropdown" href="/admin/contact">
                    <i class="fa fa-envelope-o mx-0"></i>
                </a>
            </li>
            {{-- <li class="nav-item nav-search position-relative" id="navbarSearch">
                <a class="nav-link d-flex justify-content-center align-items-center" id="navbarSearchButton"
                    href="#">
                    <i class="mdi mdi-magnify mx-0"></i>
                </a>
                <input type="text" class="form-control" placeholder="Search..." id="navbarSearchInput">
            </li> --}}
            {{-- <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                    id="messageDropdown" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-email-outline mx-0"></i>
                    <span class="count count-email"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="messageDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="{{asset('dashboard/images/faces/face4.jpg')}}" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                The meeting is cancelled
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="{{asset('dashboard/images/faces/face2.jpg')}}" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                New product launch
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="{{asset('dashboard/images/faces/face3.jpg')}}" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                Upcoming board meeting
                            </p>
                        </div>
                    </a>
                </div>
            </li> --}}
            @php
                $contact = DB::table('contacts')->where('status',0)->count();
                $order = DB::table('orders')->where('status',0)->count();
            @endphp
            
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                    id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-bell-outline mx-0"></i>
                    @if ($contact != 0)
                    <span class="count"></span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="notificationDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header"> Thông báo</p>
                    <a class="dropdown-item preview-item" title="Thông báo" href="{{route('admin.contact.index')}}">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-primary">
                                <i class="mdi mdi-account-box mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">Liên hệ</h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                {{$contact}} tin nhắn mới
                            </p>
                        </div>
                    </a>
                    {{-- <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-primary">
                                <i class="mdi mdi-settings mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">Settings</h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                Private message
                            </p>
                        </div>
                    </a> --}}
                    {{-- <a class="dropdown-item preview-item" href="{{route('admin.order.index')}}">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-primary">
                                <i class="mdi mdi-account-box mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">Đơn đặt hàng</h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                {{$order}} đơn đặt hàng mới
                            </p>
                        </div>
                    </a> --}}
                </div>
            </li>
            <li class="nav-item nav-profile dropdown mr-0 mr-sm-3">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="{{asset('public/dashboard/images/faces/face28.jpg')}}" alt="profile" />
                    <span class="nav-profile-name mr-2">
                        @if (Auth::check())
                            {{auth()->user()->fullname}}
                        @endif
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                    aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{route('admin.profile')}}">
                        <i class="mdi mdi-settings text-primary"></i>
                        Settings
                    </a>
                    <a class="dropdown-item" href="{{route('admin.logout')}}">
                        <i class="mdi mdi-logout text-primary"></i>
                        Logout
                    </a>
                </div>
            </li>
            {{-- <li class="nav-item nav-settings d-none d-lg-flex">
                <a class="nav-link d-flex justify-content-center align-items-center" href="#">
                    <i class="mdi mdi-dots-horizontal"></i>
                </a>
            </li> --}}
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>