<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config;
use App\Models\SeoPage;
use App\Models\Photo;
use Illuminate\Support\Facades\Session;

class AlbumSiteController extends Controller
{

    public function getAllAlbum()
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
        
        $album = Photo::where('status',1)->where('type','album')->get();

        return view('site.album.index', compact('album', 'settings', 'seoPage','image'));
    }
}
