<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Cart;

class OrderSiteController extends Controller
{
    public function checkOut(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:40',
            'phone' => 'required|numeric',
            'address' => 'required',
            'tinh_tp' => 'required',
            'email' => 'required|email',
            'quanHuyen' => 'required',
            'phuongXa' => 'required'
        ], [
            "name.required" => "Vui lòng nhập họ tên",
            "name.max" => "Tên không quá 40 ký tự",
            "phone.required" => "Vui lòng nhập số điện thoại",
            "phone.numeric" => "Vui lòng nhập số",
            "address.required" => "Vui lòng nhập địa chỉ",
            "tinh_tp.required" => "Vui lòng chọn tỉnh thành phố",
            "quanHuyen.required" => "Vui lòng chọn quận huyện",
            "phuongXa.required" => "Vui lòng chọn phường xã",
            "email.required" => "Vui lòng nhập email",
            "email.email" => "trường này phải là địa chỉ email"
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $value = [
                'ma_donhang' => Str::random(10),
                'email' => $request->email,
                'name' => $request->name,
                'note' => $request->note,
                'city' => $request->tinh_tp,
                'district' => $request->quanHuyen,
                'ward' => $request->phuongXa,
                'address' => $request->address,
                'status' => 0,
                'total_price' => Cart::subtotal(),
                'phone' => $request->phone,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ];
            $query = DB::table('orders')->insertGetId($value);

            if ($query) {
                //thêm đơn hàng
                $content = Cart::content();
                foreach ($content as $item) {
                    $order_detail = array();
                    $order_detail['order_id'] = $query;
                    $order_detail['product_id'] = $item->id;
                    $order_detail['created_at'] = Carbon::now();
                    $order_detail['updated_at'] = Carbon::now();
                    $order_detail['quantiti'] = $item->qty;
                    $order_detail_id = DB::table('order_detail')->insert($order_detail);
                }
                //echo dd($order_detail_id);
                Cart::destroy();
                return response()->json(['status' => 1, 'msg' => 'Gui thanh cong']);
            }
        }
    }
}
