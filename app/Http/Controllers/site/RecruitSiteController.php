<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Recruit;
use App\Models\RecruitTranslation;
use App\Models\SeoPage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RecruitSiteController extends Controller
{
    public function getRecruitBySlug($slug)
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
        $recruit = RecruitTranslation::join('recruits','recruits.id','=','recruit_translations.recruit_id')->where('recruit_translations.locale',$locale)
        ->where('recruits.status', 1)->where('recruits.slug',$slug)->first();
        if(isset($recruit)){
            return view('site.recruit.recruit_detail',compact('recruit','image'));
        }
        return abort(404);
    }

    public function getAllRecruit()
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
        $recruit = RecruitTranslation::join('recruits','recruits.id','=','recruit_translations.service_id')->where('recruit_translations.locale',$locale)
        ->where('recruits.status', 1)->orderBy('recruits.id', 'DESC')->paginate($settings['PHAN_TRANG_BAI_VIET']);
        return view('site.recruit.index', compact('recruit', 'settings', 'seoPage','image'));
    }
}
