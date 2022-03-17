<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Config;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::orderBy('id','DESC')->get();
        $row = json_decode(json_encode([
            "title" => "News",
            "desc" => "Tin tức"
        ]));
        return view("admin.news.index",compact('news','row'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $row = json_decode(json_encode([
            "title" => "Create News",
            "desc" => "Thêm tin tức"
        ]));
        return view("admin.news.add",compact('row','settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $request->validate([
            'title' => 'required|unique:news,title|max:255',
            'slug' => 'required|unique:news,slug|max:255',
            'description' => 'required',
            'content' => 'required',
            'status' => 'required',
            'photo' => 'required|mimes:jpg,png,jpeg,gif'
        ],[
                "title.required" => "Vui lòng nhập tiêu đề",
                "title.unique" => "Sản phẩm đã tồn tại",
                "title.max" => "Tên sản phẩm không quá 255 ký tự",
                "slug.required" => "Vui lòng nhập slug",
                "slug.unique" => "Slug đã tồn tại",
                "slug.max" => "Slug không quá 255 ký tự",
                "status.required" => "Vui lòng chọn trạng thái",
                "description.required" => "Vui lòng nhập mô tả",
                "content.required" => "Vui lòng nhập nội dung",
                "photo.required" => "Vui lòng thêm hình ảnh",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg, png, jpeg, gif"
        ]);

        $news = new News;
        $news->title = $request->title;
        $news->content = $request->content;
        $news->noi_bac = 0;
        $news->keywords = $request->keywords;
        $news->status = $request->status;
        $news->description = $request->description;
        $news->slug = $request->slug;
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $file_name = Str::slug($file->getClientOriginalName(), "-") . "-" . time() . "." . $file->getClientOriginalExtension();
            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_NEWS"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);
                $image_resize->save('public/upload/images/news/thumb/' . $file_name);
            }
            $news->photo = $file_name;
    
        }
        if($news->save()){
            return redirect()->back()->with(["type"=>"success","message"=>"Thêm bài viết thành công"]);
        }else{
            return back()->withInput()->with(["type"=>"danger","message"=>"Thêm bài viết thất bại"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $news = News::find($id);
        
        $row = json_decode(json_encode([
            "title" => "Update news",
            "desc" => "Chỉnh sửa tin tức: " . $news->title
        ]));

        return view("admin.news.edit",compact('news','row', 'settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $news = News::find($id);
        $request->validate([
            'title' => 'required|unique:news,title,'.$news->id.'|max:255',
            'slug' => 'required|unique:news,slug,'.$news->id.'|max:255',
            'description' => 'required',
            'content' => 'required',
            'status' => 'required',
            'photo' => 'mimes:jpg,png,jpeg,gif'
        ],[
                "title.required" => "Vui lòng nhập tiêu đề",
                "title.unique" => "Sản phẩm đã tồn tại",
                "title.max" => "Tên sản phẩm không quá 255 ký tự",
                "slug.required" => "Vui lòng nhập slug",
                "slug.unique" => "Slug đã tồn tại",
                "slug.max" => "Slug không quá 255 ký tự",
                "status.required" => "Vui lòng chọn trạng thái",
                "description.required" => "Vui lòng nhập mô tả",
                "content.required" => "Vui lòng nhập nội dung",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg, png, jpeg, gif"
        ]);
       
        $news->title = $request->title;
        $news->status = $request->status;
        $news->description = $request->description;
        $news->content = $request->content;
        $news->keywords = $request->keywords;
        $news->slug = $request->slug;
        
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $pathDel = 'public/upload/images/news/thumb/'.$news->photo;
    
            if(file_exists($pathDel)){
                unlink($pathDel);
            }
            $file = $request->photo;
            $file_name = Str::slug(explode(".", $file->getClientOriginalName())[0], "-") . "-" . time() . "." . $file->getClientOriginalExtension();

            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_NEWS"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);

                $image_resize->save('public/upload/images/news/thumb/' . $file_name);
            }

            // $file->move("public/upload/images/admins/large", $file_name);
            $news->photo = $file_name;
        }
        if($news->save()){
            return redirect()->back()->with(["type"=>"success","message"=>"Cập nhật thành công"]);
        }else{
            return back()->withInput()->with(["type"=>"danger","message"=>"Cập nhật thất bại"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = News::find($id);
        $pathDel = 'public/upload/images/news/thumb/'.$data->photo;
        
        if($data->delete()){
            if(file_exists($pathDel)){
                unlink($pathDel);
            }
            return response()->json([
                'status' => 1,
                'msg' => 'Xóa bài viết thành công'
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'msg' => 'Xóa bài viết thất bại'
            ]);
        }
    }

    public function noiBac($id,$noiBac)
    {
        $data = News::find($id);
        $data->noi_bac = $noiBac;
        if ($data->save()) {
            return response()->json([
                "status" => 1,
                "msg" => "cập nhật thành công"
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "msg" => "cập nhật thất bại"
            ]);
        }
    }

    public function status($id,$status)
    {
        $data = News::find($id);
        $data->status = $status;
        if ($data->save()) {
            return response()->json([
                "status" => 1,
                "msg" => "cập nhật thành công"
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "msg" => "cập nhật thất bại"
            ]);
        }
    }

    public function deleteAll($id = "") {
        $list_id = json_decode($id);
        //var_dump($list_id);
        //die();
        if (!isset($list_id[0]->id)) {
            return back()->withInput()->with(["type" => "danger", "message" => "Không có dữ liệu để xóa."]);
        }
        if (count($list_id) == 1 && isset($list_id[0]->id)) {
            $news = News::find($list_id[0]->id);
            if ($news->delete()) {
                $pathDel = 'public/upload/images/news/thumb/'.$news->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
                return redirect()->route("admin.news.index")->with(["type" => "success", "message" => "Xoá thành công!"]);
            } else {
                return back()->withInput()->with(["type" => "danger", "message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
            }
        } else {
            foreach ($list_id as $key => $value) {
                $news = News::find($value->id);
                $news->delete();
                $pathDel = 'public/upload/images/news/thumb/'.$news->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
            }
            return redirect()->route("admin.news.index")->with(["type" => "success", "message" => "Xóa thành công!"]);
        }
    }
}
