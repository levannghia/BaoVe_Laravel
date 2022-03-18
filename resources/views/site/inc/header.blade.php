<header>
    <div class="top-header">
        <div class="container">
            <div class="top-header-block">
                <div class="company-address">
                    <i class="fa fa-map-marker-alt"></i>
                    <span>{{ $settings['ADDRESS'] }}</span>
                </div>
                <div class="contact-block">
                    <ul class="contact-block-list">
                        <span class="follow-us">Follow us:</span>
                        @foreach ($mxh_top as $item)
                            <li class="contact-block-item">
                                <a href="{{ $item->link }}" class="contact-block-link">
                                    <img src="{{ asset('public/upload/images/photo/large/' . $item->photo) }}" alt="">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-content">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-nav">
                <div class="banner_image"><a class="navbar-brand logo-img" href="/"><img src="{{asset('public/site/images/banner-bao-ve.png')}}" alt=""></a></div>
                
                <div class="collapse navbar-collapse phone-contact" id="navbarSupportedContent">
                <div class="hot_head">
		            <div class="hot_head1">
		            	<p>{{$settings['PHONE'] .' - ' .$settings['HOTLINE']}}</p>
		            	<p>{{$settings['DTBAN']}}</p>
		            </div>
		            <div class="em_head">
		            	<p>{{$settings['EMAIL']}}</p>
		            </div>
                    <div class="ngonngu">
			            <a href="/lang/vi"><img src="{{asset('public/site/images/vietnam.png')}}" alt="Tiếng Việt"></a>
			            <a href="lang/en"><img src="{{asset('public/site/images/anh.png')}}" alt="Tiếng Anh"></a>
		             </div>
	            </div>
                
                    <!-- <ul class="navbar-nav ml-auto">
                        <a href="tel:0776768999" class="dt">
                            <span>{{ $settings['HOTLINE'] }} <p class="tell-people">(CSKH)
                                </p></span>
                            <span>{{ $settings['PHONE'] }} <p class="tell-people">(BS. HUNG)</p></span></a>
                    </ul> -->
                </div>
            </nav>
        </div>
    </div>
    <div class="menu-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-green">
                <!-- <a class="navbar-brand danh-muc pd-li" href="#"><img src="images/taxes-menu-icon.png" alt=""> DANH MỤC
                    SẢN PHẨM</a> -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav pd-li menu-category menu-center">
                        {{-- <li class="nav-item active pd-li icon-size">
                            <a class="nav-link  pd-li" href="/"><img
                                    src="{{ asset('public/site/images/taxes-menu-icon.png') }}" alt="">DANH MỤC SẢN
                                PHẨM</a>
                        </li> --}}
                        <li class="nav-item bg-ani">
                            <a class="nav-link " href="/">{{__('lang.home')}}</a>
                        </li>
                        <li class="line"></li>
                        <li class="nav-item bg-ani">
                            <a class="nav-link " href="/gioi-thieu">{{__('lang.about')}}</a>
                        </li>
                        <li class="line"></li>
                        <li class="nav-item bg-ani">
                            <a class="nav-link" href="{{ route('get.service') }}">{{__('lang.service')}}</a>
                        </li>
                        <li class="line"></li>
                        <li class="nav-item bg-ani">
                            <a class="nav-link " href="">{{__('lang.album')}}</a>
                        </li>
                        <li class="line"></li>
                        <li class="nav-item bg-ani">
                            <a class="nav-link" href="{{ route('get.news') }}">{{__('lang.news')}}</a>
                        </li>
                        <li class="line"></li>
                        <li class="nav-item bg-ani">
                            <a class="nav-link" href="{{ route('get.video') }}">{{__('lang.recruitment')}}</a>
                        </li>
                        <li class="line"></li>
                        <li class="nav-item bg-ani">
                            <a class="nav-link " href="/lien-he">{{__('lang.contacts')}}</a>
                        </li>
                        <li class="line"></li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <!-- <input class="form-control mr-sm-2 search-input" type="search" placeholder="Nhập từ khóa tìm kiếm..." aria-label="Search">
                        <button style="    border-radius: 9px; padding: 3px;" class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> -->
                    
                        <div id="search">
                            <input type="text" name="keyword" id="keyword" class="form-control mr-sm-2 search-input" type="search" placeholder="Nhập từ khóa tìm kiếm..." aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true" ></i></button>
                        </div>
                    </form>
                    
                </div>
            </nav>
        </div>
    </div>
</header>
