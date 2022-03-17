<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function loadQuanHuyen(Request $request)
    {
        $quan_huyen = DB::table('quanhuyen')->where('matp',$request->maTp)->get();
        $output = "";
        $output .= '<option selected value="">Mời bạn chọn quận huyện</option>';
        foreach ($quan_huyen as $key => $value) {
            $output .= '<option value="'.$value->maqh.'">'.$value->name.'</option>';
        }

        echo $output;
    }

    public function loadPhuongXa(Request $request)
    {
        $xa_phuong = DB::table('xaphuongthitran')->where('maqh',$request->maQh)->get();
        $output = "";
        $output .= '<option selected value="">Mời bạn chọn phường xã</option>';
        foreach ($xa_phuong as $key => $value) {
            $output .= '<option value="'.$value->name.'">'.$value->name.'</option>';
        }

        echo $output;
    }
}
