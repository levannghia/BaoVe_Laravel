<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config;
use App\Models\SeoPage;

class VideoSiteController extends Controller
{
    public function getAllVideo()
    {
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $video = DB::table('videos')->where('status', 1)->orderBy('id', 'DESC')->paginate(3);
        $seoPage = SeoPage::where('type', 'video')->first();
        $image = json_decode(
            $seoPage->options
        );

        return view('site.video.index', compact('video', 'settings', 'seoPage', 'image'));
    }
}
