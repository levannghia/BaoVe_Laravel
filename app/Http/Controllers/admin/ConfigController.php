<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;

class ConfigController extends Controller
{
    public function index()
    {
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $row = json_decode(json_encode([
            "title" => "Config",
            "desc" => "Thông tin chung"
        ]));
        return view('admin.config.index',compact('row','settings'));
    }

    public function update(Request $request)
    {
        $settings = Config::all(['name', 'id'])->keyBy('name')->transform(function ($setting) {
            return $setting->id;
        })->toArray();
        
        $phone = Config::find($settings['PHONE']);
        $phone->value = $request->phone;
        $title = Config::find($settings['TITLE']);
        $title->value = $request->title;
        $address = Config::find($settings['ADDRESS']);
        $address->value = $request->address;
        $email = Config::find($settings['EMAIL']);
        $email->value = $request->email;
        $zalo = Config::find($settings['ZALO']);
        $zalo->value = $request->zalo;
        $website = Config::find($settings['WEBSITE']);
        $website->value = $request->website;
        $map_toa_do = Config::find($settings['MAP_TOA_DO']);
        $map_toa_do->value = $request->toa_do_gg_map;
        $fanpage = Config::find($settings['FANPAGE']);
        $fanpage->value = $request->fanpage;
        $map_iframe = Config::find($settings['MAP_IFRAME']);
        $map_iframe->value = $request->gg_map_iframe;
        $analytics = Config::find($settings['ANALYTICS']);
        $analytics->value = $request->analytics;
        $master_tool = Config::find($settings['WEB_MASTER_TOOL']);
        $master_tool->value = $request->master_tool;
        $phan_trang_bv = Config::find($settings['PHAN_TRANG_BAI_VIET']);
        $phan_trang_bv->value = $request->phan_trang_bai_viet;
        $phan_trang_sp = Config::find($settings['PHAN_TRANG_PRODUCT']);
        $phan_trang_sp->value = $request->phan_trang_product;
        $hotline = Config::find($settings['HOTLINE']);
        $hotline->value = $request->hotline;
        $head_js = Config::find($settings['HEAD_JS']);
        $head_js->value = $request->head_js;
        $seo_description = Config::find($settings['SEO_DISCRIPTION']);
        $seo_description->value = $request->seo_description;
        $seo_keyword = Config::find($settings['SEO_KEYWORDS']);
        $seo_keyword->value = $request->seo_keyword;
        $seo_title = Config::find($settings['SEO_TITLE']);
        $seo_title->value = $request->seo_title;
        // $gioi_thieu_CT = Config::find($settings['GIOI_THIEU_CONG_TY']);
        // $gioi_thieu_CT->value = $request->gioi_thieu_CT;
      
        if($phone->save() && $title->save() && $address->save() && $email->save() && $zalo->save() && $website->save() && $map_toa_do->save() && 
        $map_iframe->save() && $analytics->save() && $master_tool->save() && $phan_trang_bv->save() && $phan_trang_sp->save() && $hotline->save() && $head_js->save() && 
        $seo_description->save() && $seo_keyword->save() && $seo_title->save() && $fanpage->save()){
            return redirect()->back()->with(["type"=>"success","message"=>"Cập nhật thành công"]);
        }else{
            return back()->withInput()->with(["type"=>"danger","message"=>"Cập nhật thất bại"]);
        }
    }
}
