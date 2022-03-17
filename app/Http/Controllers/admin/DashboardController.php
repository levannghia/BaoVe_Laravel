<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $row = json_decode(json_encode([
            "title" => "Dashboard",
            "desc" => "Dashboard"
        ]));
        return view('admin.dashboard.index',compact('row'));
    }

   public function thongKe(Request $request)
   {
    $row = json_decode(json_encode([
        "title" => "Dashboard",
        "desc" => "Dashboard"
    ]));
        // $year = $request->year;
        return view('admin.dashboard.index',compact('row'));
   }

//    public function test()
//    {
//        $data = time() - 600;
//        $ht = time();
//        $kq = $ht + 300;
//        $n = $ht - $data;
//        echo $n;
//     //    echo date("h:i",$ht);
//        if($n > 300){
//             echo "ra";
//        }else{
//            echo "sai";
//        }
    
//    }
}
