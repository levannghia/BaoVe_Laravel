<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\SeoPage;

class SeoPageController extends Controller
{
    public function getSeoPage($type)
    {
        $seoPage = DB::table('seo_pages')->where('type', $type)->first();
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $row = json_decode(json_encode([
            "title" => "Chỉnh sửa SEO trang: " . $seoPage->name,
            "desc" => "Chỉnh sửa SEO trang: " . $seoPage->name
        ]));
        return view("admin.seoPage.index", compact('seoPage', 'row', 'settings'));
    }

    public function postSeoPage(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|mimes:jpg,png,jpeg,gif',
        ],[
                "photo.required" => "Vui lòng thêm hình ảnh",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg, png, jpeg, gif"
        ]);
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $thumbsize = json_decode($settings['THUMB_SIZE_SEO_PAGE']);
        $seoPage = SeoPage::find($id);
        $seoPage->title = $request->seo_title;
        $seoPage->description = $request->seo_description;
        $seoPage->keywords = $request->seo_keywords;
        $file = $request->photo;
        // dd($request->photo->getClientMimeType());
        $seoPage->options = json_encode([
            "mimeType" => $file->getClientMimeType(),
            "width" => $thumbsize->width,
            "height" => $thumbsize->height,
        ]);
        
        if ($request->hasFile('photo')) {
            
            $pathDel = 'public/upload/images/seoPage/thumb/' . $seoPage->photo;

            if (file_exists($pathDel)) {
                unlink($pathDel);
            }
            $file = $request->photo;
            $file_name = Str::slug(explode(".", $file->getClientOriginalName())[0], "-") . "-" . time() . "." . $file->getClientOriginalExtension();

            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_SEO_PAGE"]);
                $image_resize->fit($thumb_size->width, $thumb_size->height);

                $image_resize->save('public/upload/images/seoPage/thumb/' . $file_name);
            }

            // $file->move("public/upload/images/admins/large", $file_name);
            $seoPage->photo = $file_name;
        }
        if ($seoPage->save()) {
            return redirect()->back()->with(["type" => "success", "message" => "Cập nhật thành công"]);
        } else {
            return back()->withInput()->with(["type" => "danger", "message" => "Cập nhật thất bại"]);
        }
    }
}
