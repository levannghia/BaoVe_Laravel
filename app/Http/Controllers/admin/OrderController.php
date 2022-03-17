<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $row = json_decode(json_encode([
            "title" => "Quản lý đơn hàng",
            "desc" => "Danh sách đơn hàng"
        ]));
        $order = Order::orderBy('id','DESC')->get();
        return view('admin.order.index',compact('order','row'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function orderDetail($id)
    {
        $settings = Config::all(['name', 'id'])->keyBy('name')->transform(function ($setting) {
            return $setting->id;
        })->toArray();
        $order = Order::select('orders.id','orders.ma_donhang','orders.phone','orders.name AS name','orders.email','orders.address','orders.note','orders.total_price',
        'orders.created_at','orders.ward','orders.status','quanhuyen.name AS quanHuyen','tinhthanhpho.name AS tinhTP')
        ->where('id',$id)->join('quanhuyen','quanhuyen.maqh','=','district')->join('tinhthanhpho','tinhthanhpho.matp','=','city')->first();
        
        // dd($order);
        if(isset($order)){
            $row = json_decode(json_encode([
                "title" => "Chi tiết đơn hàng",
                "desc" => "Chi tiết đơn hàng: " . $order->ma_donhang
            ]));
            $orderDetail = DB::table('order_detail')->select('products.id','products.type','products.price','products.name','products.photo','products.slug','order_detail.quantiti')
            ->join('orders','orders.id','=','order_detail.order_id')
            ->join('products','products.id','=','order_detail.product_id')
            ->where('orders.id',$id)->get();

            return view('admin.order.order_detail',compact('row','order','orderDetail','settings'));
        }
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        
        if($order->delete()){
            return response()->json([
                'status' => 1,
                'msg' => 'Xóa sản phẩm thành công'
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'msg' => 'Xóa sản phẩm thất bại'
            ]);
        }
    }

    public function status(Request $request)
    {
        $order = Order::find($request->id);
        $order->status = $request->st;
        if ($order->save()) {
            return response()->json([
                "status" => 1,
                "msg" => "cập nhật thành công",
                "time" => $order->updated_at->diffForHumans(),
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "msg" => "cập nhật thất bại"
            ]);
        }
    }

    public function deleteAll($id = "") {
        $list_id = json_decode($id);
        //var_dump($list_id);
        //die();
        if (!isset($list_id[0]->id)) {
            return back()->withInput()->with(["type" => "danger", "message" => "Không có dữ liệu để xóa."]);
        }
        if (count($list_id) == 1 && isset($list_id[0]->id)) {
            $order = Order::find($list_id[0]->id);
            if ($order->delete()) {
                return redirect()->route("admin.order.index")->with(["type" => "success", "message" => "Xoá thành công!"]);
            } else {
                return back()->withInput()->with(["type" => "danger", "message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
            }
        } else {
            foreach ($list_id as $key => $value) {
                $order = Order::find($value->id);
                $order->delete();
            }
            return redirect()->route("admin.order.index")->with(["type" => "success", "message" => "Xóa thành công!"]);
        }
    }
}
