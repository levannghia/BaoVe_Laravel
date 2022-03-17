<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Photo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PhotoController extends Controller
{
    public function getLogo()
    {
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $row = json_decode(json_encode([
            "title" => "Cập nhật logo",
            "desc" => "Cập nhật logo"
        ]));
        $data = DB::table('photos')->where('type','logo')->first();
        return view('admin.photo.photo',compact('data','row','settings'));
    }

    public function getFavicon()
    {
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $row = json_decode(json_encode([
            "title" => "Cập nhật favicon",
            "desc" => "Cập nhật favicon"
        ]));
        $data = DB::table('photos')->where('type','favicon')->first();
        return view('admin.photo.photo',compact('data','row','settings'));
    }

    public function postPhoto(Request $request,$id)
    {
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();

        $this->validate($request, [
            'photo' => 'mimes:jpg,png,jpeg,gif'
        ],[
            "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg, png, jpeg, gif"
        ]);

        $data = Photo::find($id);
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $pathDel = 'public/upload/images/photo/thumb/'.$data->photo;
    
            if(file_exists($pathDel)){
                unlink($pathDel);
                // var_dump(file_exists($pathDel));
                // die;
            }

            $file_name = Str::slug(explode(".", $file->getClientOriginalName())[0], "-") . "-" . time() . "." . $file->getClientOriginalExtension();

            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_LOGO"]);  
                $image_resize->fit($thumb_size->width,$thumb_size->height);

                $image_resize->save('public/upload/images/photo/thumb/' . $file_name);
            }

            // $file->move("public/upload/images/admins/large", $file_name);
            $data->photo = $file_name;
        }
        if($data->save()){
            return redirect()->back()->with(["type"=>"success","message"=>"Cập nhật thành công"]);
        }else{
            return back()->withInput()->with(["type"=>"danger","message"=>"Cập nhật thất bại"]);
        }
    }

    public function index($type)
    {
        $data = DB::table('photos')->where('type', $type)->orderBy('stt','ASC')->get();
        $row = json_decode(json_encode([
            "title" => "Danh sách photo",
            "desc" => "Danh sách hình ảnh"
        ]));
        $getType = $type;
        
        return view('admin.photo.index', compact('data', 'row', 'getType'));
    }

    public function create($type, Request $request)
    {
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $data = DB::table('photos')->where('type',$type)->first();
        $getType = $type;
        $row = json_decode(json_encode([
            "title" => "Create " . $getType,
            "desc" => "Tạo mới"
        ]));
        // dd($request->fullUrl());
        return view('admin.photo.add', compact('row', 'settings', 'data', 'getType' ));
    }

    public function store(Request $request, $type)
    {
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        
        $data = new Photo;
        $data->type = $type;
        if($type == "slide"){
            $thumb_size = json_decode($settings["THUMB_SIZE_SLIDER"]);
        }elseif($type == 'social-top'){
            $thumb_size = json_decode($settings["THUMB_SIZE_SOCIAL_TOP"]);
            $data->link = $request->link;
            $data->title = $request->title;
            $data->description = $request->description;
        }elseif($type == "partner"){
            $data->title = $request->title;
            $thumb_size = json_decode($settings["THUMB_SIZE_PARTNER"]);
        }elseif($type == "social-footer"){
            $data->link = $request->link;
            $data->title = $request->title;
            $data->description = $request->description;
            $thumb_size = json_decode($settings["THUMB_SIZE_SOCIAL_FOOTER"]);
        }
        $data->status = $request->status;
        $data->stt = $request->stt;
        $data->noi_bac = 1;
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $file_name = Str::slug($file->getClientOriginalName(), "-") . "-" . time() . "." . $file->getClientOriginalExtension();
            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                
                $image_resize->fit($thumb_size->width,$thumb_size->height);
                $image_resize->save('public/upload/images/photo/thumb/' . $file_name); 
            }
            $file->move("public/upload/images/photo/large", $file_name);
            $data->photo = $file_name;
    
        }
        if($data->save()){
            return redirect()->back()->with(["type"=>"success","message"=>"Thêm thành công"]);
        }else{
            return back()->withInput()->with(["type"=>"danger","message"=>"Thêm thất bại"]);
        }
    }

    public function edit($id)
    {
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $data = Photo::find($id);
        if(isset($data)){
            $row = json_decode(json_encode([
                "title" => "Update photo",
                "desc" => "Cập nhật photo"
            ]));
    
            return view('admin.photo.edit', compact('row', 'data','settings'));
        }
        return abort(404);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'photo' => 'mimes:jpg,png,jpeg,gif'
        ],[
            "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg, png, jpeg, gif"
        ]);
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();

        $data = Photo::find($id);
        if($data->type == "slide"){
            $thumb_size = json_decode($settings["THUMB_SIZE_SLIDER"]);
        }elseif($data->type == 'social-top'){
            $thumb_size = json_decode($settings["THUMB_SIZE_SOCIAL_TOP"]);
            $data->link = $request->link;
            $data->title = $request->title;
            $data->description = $request->description;
        }elseif($data->type == "partner"){
            $data->title = $request->title;
            $thumb_size = json_decode($settings["THUMB_SIZE_PARTNER"]);
        }elseif($data->type == "social-footer"){
            $data->link = $request->link;
            $data->title = $request->title;
            $data->description = $request->description;
            $thumb_size = json_decode($settings["THUMB_SIZE_SOCIAL_FOOTER"]);
        }
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $pathDel = 'public/upload/images/photo/thumb/'.$data->photo;
    
            if(file_exists($pathDel)){
                unlink($pathDel);
            }

            $file_name = Str::slug(explode(".", $file->getClientOriginalName())[0], "-") . "-" . time() . "." . $file->getClientOriginalExtension();

            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $image_resize->fit($thumb_size->width,$thumb_size->height);

                $image_resize->save('public/upload/images/photo/thumb/' . $file_name);
            }
            $file->move("public/upload/images/photo/large", $file_name);
            $data->photo = $file_name;
        }
        if($data->save()){
            return redirect()->back()->with(["type"=>"success","message"=>"Cập nhật thành công"]);
        }else{
            return back()->withInput()->with(["type"=>"danger","message"=>"Cập nhật thất bại"]);
        }
    }

    public function destroy($id)
    {
        $data = Photo::find($id);
        $pathDel = 'public/upload/images/photo/thumb/'.$data->photo;
        
        if($data->delete()){
            if(file_exists($pathDel)){
                unlink($pathDel);
            }
            return response()->json([
                'status' => 1,
                'msg' => 'Xóa thành công'
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'msg' => 'Xóa thất bại'
            ]);
        }
    }

    public function status($id,$status)
    {
        $data = Photo::find($id);
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
            $photo = Photo::find($list_id[0]->id);
            if ($photo->delete()) {
                $pathDel = 'public/upload/images/photo/thumb/'.$photo->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
                return redirect()->back()->with(["type" => "success", "message" => "Xoá thành công!"]);
            } else {
                return back()->withInput()->with(["type" => "danger", "message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
            }
        } else {
            foreach ($list_id as $key => $value) {
                $photo = Photo::find($value->id);  
                $photo->delete();
                $pathDel = 'public/upload/images/photo/thumb/'.$photo->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
            }
            return redirect()->back()->with(["type" => "success", "message" => "Xóa thành công!"]);
        }
    }
    public function resortPosition(Request $request){
        $data = $request->array_id;
        //dd($data);
        foreach ($data as $key => $value) {
            $standard = Photo::find($value);
            $standard->stt = $key;
            $standard->save();
        }

    }
}
