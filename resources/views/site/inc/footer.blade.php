<div class="blocks-contact">
    <div class="container">

    </div>
</div>
<footer>

    <a class="btn-effect btn-contact-block" href="tel:{{ $settings['PHONE'] }}">
        <div class="child-nth-1 animate__animated animate__zoomIn"></div>
        <div class="child-nth-2 animate__animated animate__pulse"></div>
        <p class="btn-img">
            <img src="{{ asset('public/site/images/hl.png') }}" alt="">
        </p>
    </a>
    <a class="btn-effect btn-contact-block" href="https://zalo.me/{{ $settings['ZALO'] }}">
        <div class="child-nth-1 animate__animated animate__zoomIn"></div>
        <div class="child-nth-2 animate__animated animate__pulse"></div>
        <p class="btn-img">
            <img src="{{ asset('public/site/images/zl.png') }}" alt="">
        </p>
    </a>

    <div class="container">
        <div class="row">
            <div class="col-md-4 footer-item">
                <h4>GIỚI THIỆU CÔNG TY</h4>
                
                    {!! $footer->content !!}
                
                {{-- <h1><span style="font-size:15px;"><strong style="color: #fff; font-size: 14px;">Địa chỉ
                            :</strong>&nbsp;75/50/37/9, KP.3, P. Long Bình, Tp. Biên Hòa</span></h1>
                <p><span style="font-size:15px;"><b>Hotline :&nbsp;</b>0973991122 - 0932228937</span></p>
                <p><span style="font-size:15px;"><b>Email:&nbsp;</b><a
                            href="http://yellowpages.vnn.vn/lgs/1187691384/cong-ty-tnhh-mtv-dich-vu-bao-ve-nhat-khanh-phat.html#Gửi email đến công ty"
                            style="color: rgb(0, 102, 204); font-family: Arial; text-decoration-line: none;">nhatkhanhbv@yahoo.com.vn</a></span>
                </p>
                <p><span style="font-size:15px;"><strong>Chi nhánh:</strong>&nbsp;0973991122 , 0932228937,&nbsp;
                        02513993033</span></p>
                <p>
                    <span style="font-size:15px;"><strong>Website :</strong>&nbsp;
                        <a class="a_link" href="https://baovenhatkhanhphat.com/" rel="nofollow"
                            style="color: rgb(0, 153, 51); font-family: Arial; text-decoration-line: none;"
                            target="_blank">https://baovenhatkhanhphat.com</a>
                        <a class="a_link" href="https://baovenhatkhanhphat.com/" rel="nofollow"
                            style="color: rgb(0, 153, 51); font-family: Arial; text-decoration-line: none;margin-left: 70px;"
                            target="_blank">http://baoveanninhsaigon.com</a>
                    </span>
                </p> --}}

            </div>
            <div class="col-md-4 Policy footer-item" style="padding-left: 100px;">
                <h4>DỊCH VỤ</h4>
                <a href="#">Hình Thức Thanh Toán</a>
                <a href="#">Chính Sách Bán Hàng</a>
                <a href="#">Giao & Nhận Hàng</a>
                <a href="#">Phương Thức Vận Chuyển</a>
                <a href="#">Chính Sách Bảo Mật</a>
                <a href="#">FAQs</a>
            </div>
            <div class="col-md-4 footer-item">
                <h4>BẢN ĐỒ ĐỊA ĐIỂM</h4>
                <p class="map">
                    {!! $settings['MAP_IFRAME'] !!}
                </p>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="copy-right">
            <div class="wapper">
                <div class="cop-l">© Copyright 2017 company name, All rights reserved, Design by SotaGroup</div>
                <div id="lienket">
                    @foreach ($social_footer as $item)
                    <a href="{{$item->link}}" target="_blank"><img src="{{asset('public/upload/images/photo/thumb/'.$item->photo)}}" alt="{{$item->title}}"></a>
                    @endforeach
                </div>
                <div class="cop-r"> online: <span>2</span> &nbsp;&nbsp;|&nbsp;&nbsp;Tổng truy cập:
                    <span>142196</span></div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</footer>
