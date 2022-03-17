<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class CreateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sitemap = App::make('sitemap');
        // add home pages mặc định
        $sitemap->add(URL::to('/'), Carbon::now(), 1, 'daily');
        $sitemap->add(URL::to('/lien-he'), Carbon::now(), 1, 'daily');
        $sitemap->add(URL::to('/san-pham'), Carbon::now(), 1, 'daily');
        $sitemap->add(URL::to('/mua-ban-nha-dat'), Carbon::now(), 1, 'daily');
        $sitemap->add(URL::to('/tin-tuc'), Carbon::now(), 1, 'daily');
        $sitemap->add(URL::to('/gioi-thieu'), Carbon::now(), 1, 'daily');
        $sitemap->add(URL::to('/video'), Carbon::now(), 1, 'daily');
        $sitemap->add(URL::to('/cart'), Carbon::now(), 1, 'daily');
        // add san pham
        $products = DB::table('products')->where('type', 0)->orderBy('created_at', 'desc')->get();
        foreach ($products as $item) {
            //$sitemap->add(url, thời gian, độ ưu tiên, thời gian quay lại)
            $sitemap->add(route('get.product.slug', $item->slug), $item->updated_at, 1, 'daily');
        }
        // add nha dat
        $nhaDat = DB::table('products')->where('type', 1)->orderBy('created_at', 'desc')->get();
        foreach ($nhaDat as $item) {
            //$sitemap->add(url, thời gian, độ ưu tiên, thời gian quay lại)
            $sitemap->add(route('get.nha.dat.slug', $item->slug), $item->updated_at, 1, 'daily');
        }
        // add tin tuc
        $news = DB::table('news')->orderBy('created_at', 'desc')->get();
        foreach ($news as $item) {
            //$sitemap->add(url, thời gian, độ ưu tiên, thời gian quay lại)
            $sitemap->add(route('get.news.slug', $item->slug), $item->updated_at, 2, 'daily');
        }

        // lưu file và phân quyền
        $sitemap->store('xml', 'sitemap');
        if (File::exists(public_path('sitemap.xml'))) {
            chmod(public_path('sitemap.xml'), 0777);
        }
    }
}
