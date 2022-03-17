<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Config;
use App\Models\Video;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $video = Video::orderBy('id','DESC')->get();
        $row = json_decode(json_encode([
            "title" => "Video",
            "desc" => "Danh sách video"
        ]));
        return view("admin.video.index",compact('video','row'));
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
            "title" => "Create video",
            "desc" => "Thêm video"
        ]));
        return view("admin.video.add",compact('row','settings'));
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
            'title' => 'required|unique:videos,title|max:255',
            'link_youtube' => 'required',
            'status' => 'required',
            'photo' => 'required|mimes:jpg,png,jpeg,gif'
        ],[
                "title.required" => "Vui lòng nhập tiêu đề",
                "title.unique" => "Video đã tồn tại",
                "title.max" => "Tên video không quá 255 ký tự",
                "status.required" => "Vui lòng chọn trạng thái",
                "link_youtube.required" => "Vui lòng nhập link video",
                "photo.required" => "Vui lòng thêm hình ảnh",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg, png, jpeg, gif"
        ]);

        $video = new Video;
        $video->title = $request->title;
        $video->noi_bac = 0;
        $video->status = $request->status;
        $link = strpbrk($request->link_youtube,'v=');
        $video->link_youtube = str_replace( 'v=', '', $link );
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $file_name = Str::slug($file->getClientOriginalName(), "-") . "-" . time() . "." . $file->getClientOriginalExtension();
            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_VIDEO"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);
                $image_resize->save('public/upload/images/video/thumb/' . $file_name);
            }
            $video->photo = $file_name;
    
        }
        if($video->save()){
            return redirect()->back()->with(["type"=>"success","message"=>"Thêm video thành công"]);
        }else{
            return back()->withInput()->with(["type"=>"danger","message"=>"Thêm video viết thất bại"]);
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
        $video = Video::find($id);
        if(isset($video)){
            $row = json_decode(json_encode([
                "title" => "Update video",
                "desc" => "Chỉnh sửa video: " . $video->title
            ]));
            return view("admin.video.edit",compact('video', 'row', 'settings'));
        }

        return abort(404);
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
        $video = Video::find($id);
        $request->validate([
            'title' => 'required|unique:videos,title,'.$video->id.'|max:255',
            'link_youtube' => 'required',
            'status' => 'required',
            'photo' => 'mimes:jpg,png,jpeg,gif'
        ],[
                "title.required" => "Vui lòng nhập tiêu đề",
                "title.unique" => "Video đã tồn tại",
                "title.max" => "Tên video không quá 255 ký tự",
                "status.required" => "Vui lòng chọn trạng thái",
                "link_youtube.required" => "Vui lòng nhập link video",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg, png, jpeg, gif"
        ]);
       
        $video->title = $request->title;
        $video->status = $request->status;
        $link = strpbrk($request->link_youtube,'v=');
        $video->link_youtube = str_replace( 'v=', '', $link );
        
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $pathDel = 'public/upload/images/video/thumb/'.$video->photo;
    
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

                $image_resize->save('public/upload/images/video/thumb/' . $file_name);
            }

            // $file->move("public/upload/images/admins/large", $file_name);
            $video->photo = $file_name;
        }
        if($video->save()){
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
        $data = Video::find($id);
        $pathDel = 'public/upload/images/video/thumb/'.$data->photo;
        
        if($data->delete()){
            if(file_exists($pathDel)){
                unlink($pathDel);
            }
            return response()->json([
                'status' => 1,
                'msg' => 'Xóa video thành công'
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'msg' => 'Xóa video thất bại'
            ]);
        }
    }

    public function noiBac($id,$noiBac)
    {
        $data = Video::find($id);
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
        $data = Video::find($id);
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
            $video = Video::find($list_id[0]->id);
            if ($video->delete()) {
                $pathDel = 'public/upload/images/video/thumb/'.$video->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
                return redirect()->route("admin.video.index")->with(["type" => "success", "message" => "Xoá thành công!"]);
            } else {
                return back()->withInput()->with(["type" => "danger", "message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
            }
        } else {
            foreach ($list_id as $key => $value) {
                $video = Video::find($value->id);
                $video->delete();
                $pathDel = 'public/upload/images/video/thumb/'.$video->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
            }
            return redirect()->route("admin.video.index")->with(["type" => "success", "message" => "Xóa thành công!"]);
        }
    }
}
