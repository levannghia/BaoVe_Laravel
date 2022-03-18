<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function getPage($slug)
    {
        $page = DB::table('pages')->where('slug',$slug)->first();
        $row = json_decode(json_encode([
            "title" => "Cập nhật trang " . $page->name,
            "desc" => "Cập nhật trang: " . $page->name
        ]));

        $page_vi = DB::table('pages')->join('page_translations','page_translations.page_id','=','pages.id')
        ->where('page_translations.page_id',$page->id)->where('page_translations.locale','vi')->first();

        $page_en = DB::table('pages')->join('page_translations','page_translations.page_id','=','pages.id')
        ->where('page_translations.page_id',$page->id)->where('page_translations.locale','en')->first();

        return view("admin.pages.index",compact('page', 'row', 'page_vi','page_en'));
    }

    public function postPage(Request $request,$id)
    {
        $data = $request->all();
        $page = Page::find($id);
        if($page->slug == 'footer'){
            $page->fill([
                'en' => [
                    'content' => $data['content:en'],
                ],
                'vi' => [
                    'content' => $data['content:vi'],
                ],
            ]);
        }else{
            $page->fill([
                'en' => [
                    'title' => $data['title:en'],
                    'content' => $data['content:en'],
                ],
                'vi' => [
                    'title' => $data['title:vi'],
                    'content' => $data['content:vi'],
                ],
            ]);
        }

        if($page->save()){
            return redirect()->back()->with(["type"=>"success","message"=>"Cập nhật thành công"]);
        }else{
            return back()->back()->with(["type"=>"danger","message"=>"Cập nhật thất bại"]);
        }
    }
}
