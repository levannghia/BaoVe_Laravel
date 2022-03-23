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
        $sitemap->add(URL::to('/dich-vu'), Carbon::now(), 1, 'daily');
        $sitemap->add(URL::to('/tin-tuc'), Carbon::now(), 1, 'daily');
        $sitemap->add(URL::to('/gioi-thieu'), Carbon::now(), 1, 'daily');
        $sitemap->add(URL::to('/album'), Carbon::now(), 1, 'daily');
        $sitemap->add(URL::to('/tuyen-dung'), Carbon::now(), 1, 'daily');
        // add san pham
        $service = DB::table('services')->orderBy('created_at', 'desc')->get();
        foreach ($service as $item) {
            //$sitemap->add(url, thời gian, độ ưu tiên, thời gian quay lại)
            $sitemap->add(route('get.service.slug', $item->slug), $item->updated_at, 1, 'daily');
        }
        // add nha dat
        $tuyenDung = DB::table('recruits')->orderBy('created_at', 'desc')->get();
        foreach ($tuyenDung as $item) {
            //$sitemap->add(url, thời gian, độ ưu tiên, thời gian quay lại)
            $sitemap->add(route('get.recruit.slug', $item->slug), $item->updated_at, 1, 'daily');
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
