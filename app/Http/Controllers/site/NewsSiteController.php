<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config;
use App\Models\SeoPage;
use App\Models\NewsTranslation;
use Illuminate\Support\Facades\Session;

class NewsSiteController extends Controller
{
    public function getNewsBySlug($slug)
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
        $news = DB::table('news')->where('status', 1)->where('slug', $slug)->first();
        $news_lq = DB::table('news')->where('status', 1)->where('id','!=',$news->id)->limit(3)->get();
        if(isset($news)){
            return view('site.news.new_detail',compact('news','image','news_lq'));
        }
        return abort(404);
    }

    public function getAllNews()
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
        $news = NewsTranslation::join('news','news.id','=','news_translations.news_id')->where('news_translations.locale',$locale)
        ->where('news.status', 1)->orderBy('news.id', 'DESC')->paginate($settings['PHAN_TRANG_BAI_VIET']);
        return view('site.news.index', compact('news', 'settings', 'seoPage','image'));
    }
}
