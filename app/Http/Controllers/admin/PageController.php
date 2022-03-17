<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
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
        return view("admin.pages.index",compact('page', 'row'));
    }

    public function postPage(Request $request,$id)
    {
        $page = Page::find($id);
        $page->title = $request->title;
        $page->content = $request->content;

        if($page->save()){
            return redirect()->back()->with(["type"=>"success","message"=>"Cập nhật thành công"]);
        }else{
            return back()->back()->with(["type"=>"danger","message"=>"Cập nhật thất bại"]);
        }
    }
}
