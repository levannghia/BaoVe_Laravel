<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\SeoPage;

class PageSiteController extends Controller
{
    public function getPageLienHe()
    {
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $page = DB::table('pages')->where('slug','lien-he')->first();
        $seoPage = SeoPage::where('type', 'lien-he')->first();
        $image = json_decode(
            $seoPage->options
        );
        //dd($image);
        return view('site.contact.index',compact('page','settings','seoPage','image'));
    }

    public function getPageGioiThieu()
    {
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $page = DB::table('pages')->where('slug','gioi-thieu')->first();
        $seoPage = SeoPage::where('type', 'gioi-thieu')->first();
        $image = json_decode(
            $seoPage->options
        );
        //dd($image);
        return view('site.about.index',compact('page','settings','seoPage','image'));
    }

    public function postLienHe(Request $request){
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:40',
            'phone' => 'required|numeric',
            'address' => 'required',
            'note' => 'required',
            'content' => 'required',
            'email' => 'required|email'
        ], [
            "name.required" => "Vui lòng nhập họ tên",
            "name.max" => "Tên không quá 40 ký tự",
            "phone.required" => "Vui lòng nhập số điện thoại",
            "address.required" => "Vui lòng nhập địa chỉ",
            "note.required" => "Vui lòng nhập tiêu đề",
            "content.required" => "Vui lòng nhập nội dung",
            "email.required" => "Vui lòng nhập email",
            "phone.numeric" => "Trường này phải là số",
            "email.email" => "Vui lòng nhập email"
        ]);


        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $value = [
                'email' => $request->email,
                'name' => $request->name,
                'note' => $request->note,
                'content' => $request->content,
                'address' => $request->address,
                'status' => 0,
                'phone' => $request->phone,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ];
            $query = DB::table('contacts')->insert($value);

            if ($query) {
                return response()->json(['status' => 1, 'msg' => 'Gui thanh cong']);
            }
        }
    }
}
