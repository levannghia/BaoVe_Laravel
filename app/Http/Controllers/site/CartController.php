<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config;
use App\Models\SeoPage;
use App\Models\Products;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Cart;

class CartController extends Controller
{
    public function saveCart(Request $request)
    {
        $id = $request->product_id;
        $quantiti = $request->quantiti;
        $product_detail = Products::where('id', $id)->first();

        $data['id'] = $product_detail->id;
        $data['qty'] = $quantiti;
        $data['name'] = $product_detail->name;
        $data['options']['image'] = $product_detail->photo;
        if ($product_detail->price != NULL) {
            $data['price'] = $product_detail->price;
            $data['weight'] = $product_detail->price;
        } else {
            $data['price'] = 0;
            $data['weight'] = 0;
        }
        Cart::add($data);
        return Redirect::to('/cart');
    }

    public function deleteCart($rowId)
    {
        Cart::update($rowId, 0);
        return Redirect::to('/cart');
    }

    public function updateCart(Request $request)
    {
        //$id = $request->product_id;
        //$product_detail = Products::where('id', $id)->first();
        $validator = Validator::make($request->all(), [
            'qty' => 'numeric',

        ], [
            "qty.numeric" => "Vui lòng nhập số"
        ]);

        $rowId = $request->rowId;
        $qty = $request->qty;

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            if (Cart::update($rowId, $qty)) {
                return response()->json([
                    'status' => 1,
                    'msg' => 'update successfully'
                ]);
            }
        }
    }

    public function getCart()
    {
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $seoPage = SeoPage::where('type', 'san-pham')->first();
        $image = json_decode(
            $seoPage->options
        );
        $tinh_tp = DB::table('tinhthanhpho')->get();
        return view('site.cart.cart', compact('tinh_tp','seoPage', 'image', 'settings'));
    }
}
