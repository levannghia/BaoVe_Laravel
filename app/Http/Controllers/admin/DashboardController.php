<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('admin.dashboard.index', compact('row'));
    }

    public function thongKe(Request $request)
    {
        $date = $request->date;
        $myMonth = date('m', strtotime($date));
        $myYear =  date('Y', strtotime($date));
        $daysInMonth = cal_days_in_month(0, $myMonth, $myYear);
        $countMount = DB::table('counter')->whereMonth('created_at', $myMonth)->whereYear('created_at', $myYear)->count();
        for($i = 1; $i <= $daysInMonth; $i++){
            $countDay = DB::table('counter')->whereMonth('created_at', $myMonth)->whereYear('created_at', $myYear)->whereDay('created_at', $i)->count();
            if ($countDay > 0) {
                    $chartData[] = array(
                        'period' => $myYear.'-'.$myMonth.'-'.$i,
                        'counter' => $countDay,
                    );
            }else{
                $chartData[] = array(
                    'period' => $myYear.'-'.$myMonth.'-'.$i,
                    'counter' => 0,
                );
            }
        }

        echo $data = json_encode(['data_day'=>$chartData,'totalMonth'=>$countMount,'monthCurrent' => $myMonth]);
    }

    public function thongKeNow()
    {
        $date = Carbon::now();
        $myMonth = date('m', strtotime($date));
        $myYear =  date('Y', strtotime($date));
        $daysInMonth = cal_days_in_month(0, $myMonth, $myYear);
        $countMount = DB::table('counter')->whereMonth('created_at', $myMonth)->whereYear('created_at', $myYear)->count();
        for($i = 1; $i <= $daysInMonth; $i++){
            $countDay = DB::table('counter')->whereMonth('created_at', $myMonth)->whereYear('created_at', $myYear)->whereDay('created_at', $i)->count();
            if ($countDay > 0) {
                    $chartData[] = array(
                        'period' => $myYear.'-'.$myMonth.'-'.$i,
                        'counter' => $countDay,
                    );
            }else{
                $chartData[] = array(
                    'period' => $myYear.'-'.$myMonth.'-'.$i,
                    'counter' => 0,
                );
            }
        }

        echo $data = json_encode(['data_day'=>$chartData,'totalMonth'=>$countMount,'monthCurrent' => $myMonth]);
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
