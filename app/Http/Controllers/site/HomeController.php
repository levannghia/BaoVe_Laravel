<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\SeoPage;
use App\Models\Category;
use App\Models\Service;
use App\Models\Products;
use App\Models\Standard;
use App\Models\News;
use App\Models\Photo;
use App\Models\Review;
use App\Models\Video;
use File;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Cart;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    public function siteMap()
    {
        
        Artisan::call('sitemap:create');
    }
    
    public function index()
    { 
        // echo App::currentLocale();
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $image = json_decode(json_encode([
            "mimeType" => "image/png",
            "width" => 110,
            "height" => 110,
        ]));

        $review = Review::where('status',1)->where('noi_bac',1)->get();
        $slider = Photo::where('status',1)->where('type','slide')->orderBy('stt','ASC')->get();
        $video = Video::where('status',1)->where('noi_bac',1)->orderBy('id','DESC')->limit(3)->get();
        $news = News::where('status', 1)->where('noi_bac', 1)->orderBy('id', 'DESC')->get();
        $service = Service::where('status', 1)->where('noi_bac', 1)->orderBy('id', 'DESC')->get();
        $standard = Standard::where('status', 1)->orderBy('stt', 'ASC')->get();
        $pageGT = DB::table('pages')->where('slug','gioi-thieu')->first();
        $category = Category::where('status', 1)->orderBy('stt', 'ASC')->get();
        
        $nhaDat = Products::where('status', 1)->where('noi_bac', 1)->orderBy('id', 'DESC')->where('type', 1)->limit(8)->get();
        // $cate_product = Products::select('products.id','products.name','products.price','products.view','products.photo','categories.name AS category_name')
        // ->join('categories', 'categories.id','=','products.category_id')
        // ->where('categories.id',$category_noibac[0]['id'])->where('products.type',0)->where('products.status',1)->orderBy('categories.stt', 'ASC')->paginate($settings['PHAN_TRANG_PRODUCT']);
        return view('site.home.index', compact('review','video','slider','settings', 'image', 'pageGT', 'standard', 'news','service', 'nhaDat'));
    }

    public function showMap(Request $request)
    {
        $nhaDat = Products::where('status', 1)->where('noi_bac', 1)->where('id', $request->id)->where('type', 1)->first();

        if (isset($nhaDat)) {
            return response()->json([
                'status' => true,
                'data' => $nhaDat,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'get failed',
            ]);
        }
    }

    public function getProductByCategory(Request $request){
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $output = "";
        $p ="";
        $cate_product = Products::select('products.id','products.name','products.price','products.view','products.slug','products.photo','categories.name AS category_name')
        ->join('categories', 'categories.id','=','products.category_id')
        ->where('categories.id',$request->id)->where('products.type',0)->where('products.noi_bac',1)->where('products.status',1)->orderBy('stt', 'ASC')->paginate($settings['PHAN_TRANG_PRODUCT']);
        $output .= '<div class="row">';
        foreach ($cate_product as $key => $item) {
            if($item->price == NULL){
                $p = '<p class="product-price">Giá: <a href="tel:'.$settings['PHONE'].'" class="contact-product">Liên hệ</a> </p>';
            }else{
                $p = '<p class="product-price">Giá: <a href="/san-pham/'.$item->slug.'" class="contact-product">'.number_format($item->price, 0, ',', '.').' đ</a> </p>';
            }
            $output .= '
            <div class="col-md-3 col-6 img-flu">
                <div class="border-col">
                <div class="detail-product-link">
                    <a href="/san-pham/'.$item->slug.'"><img src="public/upload/images/product/thumb/'.$item->photo.'" alt="">
                    </a>
                    </div>
                    <a href="/san-pham/'.$item->slug.'"><h6 class="product-name">'.$item->name.'</h6></a>
                    
                    <div class="price-view">
                        '.$p.'
                        <p class="product-views">Lượt xem: '.$item->view.'</p>
                    </div>
                </div>
        </div>';
        }
        $output .= "</div>";

        echo $output;
    }

    public function Search(Request $request)
    {
        $search = $request->q;
        $data = Products::where("name", "like", '%' . $request->q . '%')->where('status',1)->where('type',0)->orderBy('id', 'desc')->paginate(8);
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $seoPage = SeoPage::where('type', 'san-pham')->first();
          
        return view('site.product.search', compact('data', 'seoPage', 'settings','search'));

    }

    public function showProductInCategoryLV1($id){
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $output = "";
        $p ="";
        $cate_lv1_show_product = DB::table('categories_lv1')->select('products.name','products.slug','products.view','products.photo','products.price','products.id')
        ->leftJoin('categories','categories.category_lv1_id','=','categories_lv1.id')
        ->leftJoin('products','products.category_id','=','categories.id')->where('categories_lv1.noi_bac',1)->where('categories_lv1.status',1)->where('categories_lv1.id',$id)->where('categories.status',1)->where('products.status',1)->where('products.noi_bac',1)->where('products.type',0)->orderBy('categories.stt','ASC')->limit(4)->get();
        $output .= '<div class="row">';
        foreach ($cate_lv1_show_product as $key => $item) {
            if($item->price == NULL){
                $p = '<p class="product-price">Giá: <a href="tel:'.$settings['PHONE'].'" class="contact-product">Liên hệ</a> </p>';
            }else{
                $p = '<p class="product-price">Giá: <a href="/san-pham/'.$item->slug.'" class="contact-product">'.number_format($item->price, 0, ',', '.').' đ</a> </p>';
            }
            $output .= '
            <div class="col-md-3 col-6 img-flu">
                <div class="border-col">
                <div class="detail-product-link">
                    <a href="/san-pham/'.$item->slug.'"><img src="public/upload/images/product/thumb/'.$item->photo.'" alt="">
                    </a>
                    </div>
                    <a href="/san-pham/'.$item->slug.'"><h6 class="product-name">'.$item->name.'</h6></a>
                    
                    <div class="price-view">
                        '.$p.'
                        <p class="product-views">Lượt xem: '.$item->view.'</p>
                    </div>
                </div>
        </div>';
        }
        $output .= "</div>";

        echo $output;
    }

    public function hoverCategoryLV1(Request $request){

        $cate_slide = DB::table('categories')
            ->select('categories.name', 'categories.slug', 'categories.id')
            ->join('categories_lv1', 'categories_lv1.id', '=', 'categories.category_lv1_id')
            ->where('categories.status', 1)
            ->where('categories_lv1.id', $request->id)
            ->orderBy('categories.stt', 'ASC')
            ->get();
        $output = "";
        foreach ($cate_slide as $key => $item) {
            $output .= '<a href="/danh-muc/'.$item->slug.'">'.$item->name.'</a>';
        }
        echo $output;
    }
}
