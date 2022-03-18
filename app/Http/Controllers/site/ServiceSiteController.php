<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Service;
use App\Models\ServiceTranslation;
use App\Models\SeoPage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ServiceSiteController extends Controller
{
    public function getServiceBySlug($slug)
    {
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $image = json_decode(json_encode([
            "mimeType" => "image/png",
            "width" => 600,
            "height" => 400,
        ]));
        $locale = Session::get('locale');
        $service = ServiceTranslation::join('services','services.id','=','service_translations.service_id')->where('service_translations.locale',$locale)
        ->where('services.status', 1)->where('services.slug',$slug)->first();
        // $service_lq = DB::table('services')->where('status', 1)->where('id','!=',$service->id)->limit(3)->get();
        if(isset($service)){
            return view('site.service.service_detail',compact('service','image'));
        }
        return abort(404);
    }

    public function getAllService()
    {
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $seoPage = SeoPage::where('type', 'tin-tuc')->first();
        $image = json_decode(
            $seoPage->options
        );
        $locale = Session::get('locale');
        $service = ServiceTranslation::join('services','services.id','=','service_translations.service_id')->where('service_translations.locale',$locale)
        ->where('services.status', 1)->orderBy('services.id', 'DESC')->paginate($settings['PHAN_TRANG_BAI_VIET']);
        return view('site.service.index', compact('service', 'settings', 'seoPage','image'));
    }
}
