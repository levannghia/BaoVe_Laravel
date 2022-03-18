<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Recruit;
use App\Models\Config;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\RecruitTranslation;
use Illuminate\Support\Facades\DB;

class RecruitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recruit = Recruit::orderBy('id','DESC')->get();
        $row = json_decode(json_encode([
            "title" => "Tuyển Dụng",
            "desc" => "tuyển dụng"
        ]));
        return view("admin.recruit.index",compact('recruit','row'));
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
            "title" => "Create recruit",
            "desc" => "Thêm tin tuyển dụng"
        ]));
        return view("admin.recruit.add",compact('row','settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();

        $request->validate([
            'slug' => 'required|unique:news,slug|max:255',
            'status' => 'required',
            'photo' => 'required|mimes:jpg,png,jpeg,gif'
        ],[
                "slug.required" => "Vui lòng nhập slug",
                "slug.unique" => "Slug đã tồn tại",
                "slug.max" => "Slug không quá 255 ký tự",
                "status.required" => "Vui lòng chọn trạng thái",
                "photo.required" => "Vui lòng thêm hình ảnh",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg, png, jpeg, gif"
        ]);

        $recruit = new Recruit;

        $recruit->fill([
            'en' => [
                'title' => $data['title:en'],
                'description' => $data['description:en'],
                'content' => $data['content:en'],
            ],
            'vi' => [
                'title' => $data['title:vi'],
                'description' => $data['description:vi'],
                'content' => $data['content:vi'],
            ],
        ]);
        $recruit->noi_bac = 0;
        $recruit->keywords = $request->keywords;
        $recruit->status = $request->status;
        $recruit->slug = $request->slug;
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $file_name = Str::slug($file->getClientOriginalName(), "-") . "-" . time() . "." . $file->getClientOriginalExtension();
            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_RECRUIT"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);
                $image_resize->save('public/upload/images/recruit/thumb/' . $file_name);
            }
            $recruit->photo = $file_name;
    
        }
        if($recruit->save()){
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

        $recruit_vi = DB::table('recruits')->join('recruit_translations','recruit_translations.recruit_id','=','recruits.id')
        ->where('recruit_translations.recruit_id',$id)->where('recruit_translations.locale','vi')->first();

        $recruit_en = DB::table('recruits')->join('recruit_translations','recruit_translations.recruit_id','=','recruits.id')
        ->where('recruit_translations.recruit_id',$id)->where('recruit_translations.locale','en')->first();
 
        $row = json_decode(json_encode([
            "title" => "Update recruit",
            "desc" => "Chỉnh sửa tin tuyển dụng"
        ]));

        return view("admin.recruit.edit",compact('recruit_vi','recruit_en','row', 'settings'));
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
        $data = $request->all();
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $recruit = Recruit::find($id);
        $request->validate([
            'slug' => 'required|unique:recruits,slug,'.$recruit->id.'|max:255',
            'status' => 'required',
            'photo' => 'mimes:jpg,png,jpeg,gif'
        ],[
                "slug.required" => "Vui lòng nhập slug",
                "slug.unique" => "Slug đã tồn tại",
                "slug.max" => "Slug không quá 255 ký tự",
                "status.required" => "Vui lòng chọn trạng thái",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg, png, jpeg, gif"
        ]);
       
        $recruit->fill([
            'en' => [
                'title' => $data['title:en'],
                'description' => $data['description:en'],
                'content' => $data['content:en'],
            ],
            'vi' => [
                'title' => $data['title:vi'],
                'description' => $data['description:vi'],
                'content' => $data['content:vi'],
            ],
        ]);

        $recruit->status = $request->status;
        $recruit->keywords = $request->keywords;
        $recruit->slug = $request->slug;
        
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $pathDel = 'public/upload/images/recruit/thumb/'.$recruit->photo;
    
            if(file_exists($pathDel)){
                unlink($pathDel);
            }
            $file = $request->photo;
            $file_name = Str::slug(explode(".", $file->getClientOriginalName())[0], "-") . "-" . time() . "." . $file->getClientOriginalExtension();

            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_RECRUIT"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);

                $image_resize->save('public/upload/images/recruit/thumb/' . $file_name);
            }

            // $file->move("public/upload/images/admins/large", $file_name);
            $recruit->photo = $file_name;
        }
        if($recruit->save()){
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
        $data = Recruit::find($id);
        $pathDel = 'public/upload/images/recruit/thumb/'.$data->photo;
        
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
        $data = Recruit::find($id);
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
        $data = Recruit::find($id);
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
            $news = Recruit::find($list_id[0]->id);
            if ($news->delete()) {
                $pathDel = 'public/upload/images/recruit/thumb/'.$news->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
                return redirect()->route("admin.recruit.index")->with(["type" => "success", "message" => "Xoá thành công!"]);
            } else {
                return back()->withInput()->with(["type" => "danger", "message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
            }
        } else {
            foreach ($list_id as $key => $value) {
                $news = Recruit::find($value->id);
                $news->delete();
                $pathDel = 'public/upload/images/recruit/thumb/'.$news->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
            }
            return redirect()->route("admin.recruit.index")->with(["type" => "success", "message" => "Xóa thành công!"]);
        }
    }
}
