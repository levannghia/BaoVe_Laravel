<?php
session_start();
use Carbon\Carbon;
function getIPAddress()
{
    //whether ip is from the share internet
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from the proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //whether ip is from the remote address
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


$time_out = 180; //giay
$ip = getIPAddress();
$id_online = session_id();
$check_id = DB::table('user_online')->where('id', $id_online)->get();

//dem truy cap
if(!session()->has('id_counter')){
    $created_counter =  DB::table('counter')->insert([['ip' => $ip, 'created_at' => Carbon::now()]]);
    session()->put('id_counter', $id_online);
}

if (count($check_id) != 0) {
    DB::table('user_online')->where('id', $id_online)->update(['last_visit' => time(),'ip'=> $ip]);
} else {
    DB::table('user_online')->insert([['id' => $id_online, 'ip' => $ip, 'last_visit' => time()]]);
}

$all_user_online = DB::table('user_online')->get();
foreach ($all_user_online as $key => $value) {
    $last_visit = $value->last_visit;
    $time = time() - $last_visit;
    if($time > $time_out){
        $delete_user_online =  DB::table('user_online')->where('id',$value->id)->delete();
    }
}

$user_online = count($all_user_online);


// tong so truy cap
$counter = DB::table('counter')->count();
?>

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
                <h4>{{__('lang.company_introduction')}}</h4>

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
                <h4>{{ __('lang.service') }}</h4>
                @foreach ($serviceFooter as $item)
                <a href="/dich-vu/{{$item->slug}}">{{$item->title}}</a>
                @endforeach
                
            </div>
            <div class="col-md-4 footer-item">
                <h4>Fanpage</h4>
                <p class="map">
                    <div class="fb-page" data-href="{{$settings['FANPAGE']}}" data-tabs="timeline" data-width="" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="{{$settings['FANPAGE']}}" class="fb-xfbml-parse-ignore"><a href="{{$settings['FANPAGE']}}"></a></blockquote></div>
                    
                </p>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="copy-right">
            <div class="wapper">
                <div class="cop-l">© Copyright 2017 company name, All rights reserved, Design by SotaGroup
                </div>
                <div id="lienket">
                    @foreach ($social_footer as $item)
                        <a href="{{ $item->link }}" target="_blank"><img
                                src="{{ asset('public/upload/images/photo/thumb/' . $item->photo) }}"
                                alt="{{ $item->title }}"></a>
                    @endforeach
                </div>
                <div class="cop-r"> online: <span>{{$user_online}}</span> &nbsp;&nbsp;|&nbsp;&nbsp;{{__('lang.total_hits')}}:
                    <span>{{$counter}}</span>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</footer>
