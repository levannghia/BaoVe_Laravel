<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config;
use App\Models\Products;
use App\Models\Category;
use App\Models\SeoPage;
use App\Models\Photo;
use App\Models\Category_LV1;

class ProductSiteController extends Controller
{
    public function productCategory($slug)
    {
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $category_slide = Category_LV1::where('categories_lv1.status', 1)->orderBy('categories_lv1.stt', 'ASC')->get();
        $slider = Photo::where('status',1)->where('type','slide')->orderBy('stt','ASC')->get();
        $category = Category::where('status', 1)->orderBy('stt', 'ASC')->get();
        $category_name = Category::where('status', 1)->where('slug',$slug)->orderBy('stt', 'ASC')->first();
        $seoPage = SeoPage::where('type', 'danh-muc')->first();
        $cate_pro = Products::select('products.photo', 'products.name', 'products.price', 'products.slug','products.view')
        ->join('categories', 'categories.id', '=', 'products.category_id')->where('categories.slug',$slug)->where('products.type', 0)->where('products.status', 1)->paginate($settings['PHAN_TRANG_PRODUCT']);
        return view('site.product.product_category',compact('category_slide','cate_pro','seoPage','category','slider','settings','category_name'));
    }
    public function getProductBySlug($slug)
    {
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $seoPage = SeoPage::where('type', 'san-pham')->first();
        $product = Products::where('type', 0)->where('status', 1)->where('slug', $slug)->first();
        if (isset($product)) {
            // đếm lượt xem
            $view = $product->view + 1;
            $product->view = $view;
            $product->save();

            $gallery = DB::table('galleries')->select('galleries.photo')
                ->join('products', 'products.id', '=', 'galleries.product_id')->where('galleries.status', 1)->where('products.id', $product->id)
                ->orderBy('galleries.stt', 'ASC')->get();
            //sp lien quan
            $product_cate = Products::select('products.photo', 'products.name', 'products.price', 'products.slug','products.view')
                ->join('categories', 'categories.id', '=', 'products.category_id')->where('products.type', 0)->where('products.status', 1)->limit(4)->get();

            return view('site.product.product_detail', compact('product', 'gallery', 'seoPage', 'settings', 'product_cate'));
        }
        return abort(404);
    }

    public function getAllProduct()
    {
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $seoPage = SeoPage::where('type', 'san-pham')->first();
        $image = json_decode(
            $seoPage->options
        );
        $product = DB::table('products')->where('type', 0)->where('status', 1)->paginate($settings['PHAN_TRANG_PRODUCT']);
        return view('site.product.index', compact('product', 'seoPage', 'image', 'settings'));
    }

    public function getNhaDatBySlug($slug)
    {
        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $nhaDat = DB::table('products')->where('type', 1)->where('status', 1)->where('slug', $slug)->first();
        $gallery = DB::table('galleries')->select('galleries.photo')
            ->join('products', 'products.id', '=', 'galleries.product_id')->where('galleries.status', 1)->where('products.id', $nhaDat->id)
            ->orderBy('galleries.stt', 'ASC')->get();
        return view('site.product.nhaDat_detail',compact('nhaDat','gallery','settings'));
    }

    public function getAllNhaDat()
    {


        $settings = Config::all(['name', 'value'])
            ->keyBy('name')
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();
        $seoPage = SeoPage::where('type', 'mua-ban-nha-dat')->first();
        $image = json_decode(
            $seoPage->options
        );
        $nhaDat = DB::table('products')->where('type', 1)->where('status', 1)->paginate($settings['PHAN_TRANG_PRODUCT']);

        return view('site.product.nhaDat',compact('settings','image','nhaDat','seoPage'));
    }
}
