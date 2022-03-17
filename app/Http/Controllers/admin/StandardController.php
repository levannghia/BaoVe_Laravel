<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Standard;
use App\Models\Config;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class StandardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $standard = Standard::orderBy('stt','ASC')->get();
        $row = json_decode(json_encode([
            "title" => "Tiêu chí",
            "desc" => "Tiêu chí"
        ]));
        return view("admin.standard.index",compact('standard','row'));
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
            "title" => "Thêm tiêu chí",
            "desc" => "Thêm tiêu chí"
        ]));
        return view("admin.standard.add",compact('row','settings'));
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
            'description' => 'required',
            'stt' => 'required|numeric',
            'status' => 'required',
            'photo' => 'required|mimes:jpg,png,jpeg,gif'
        ],[
                "title.required" => "Vui lòng nhập tiêu đề",
                "title.unique" => "Sản phẩm đã tồn tại",
                "title.max" => "Tên sản phẩm không quá 255 ký tự",
                "status.required" => "Vui lòng chọn trạng thái",
                "description.required" => "Vui lòng nhập mô tả",
                "stt.required" => "Vui lòng nhập số thứ tự",
                "stt.numeric" => "Trường số thứ tự phải là số",
                "photo.required" => "Vui lòng thêm hình ảnh",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg, png, jpeg, gif"
        ]);

        $standard = new Standard;
        $standard->title = $request->title;
        $standard->stt = $request->stt;
        $standard->status = $request->status;
        $standard->description = $request->description;
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $file_name = Str::slug($file->getClientOriginalName(), "-") . "-" . time() . "." . $file->getClientOriginalExtension();
            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_STANDARD"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);
                $image_resize->save('public/upload/images/standard/thumb/' . $file_name);
            }
            $standard->photo = $file_name;
    
        }
        if($standard->save()){
            return redirect()->back()->with(["type"=>"success","message"=>"Thêm tiêu chí thành công"]);
        }else{
            return back()->withInput()->with(["type"=>"danger","message"=>"Thêm tiêu chí thất bại"]);
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
        $standard = Standard::find($id);
        if(isset($standard)){
            $row = json_decode(json_encode([
                "title" => "Cập nhật tiêu chí",
                "desc" => "Cập nhật tiêu chí: " . $standard->title
            ]));
            return view("admin.standard.edit",compact('standard','row', 'settings'));
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
        $standard = Standard::find($id);
        $request->validate([
            'title' => 'required|unique:standards,title,'.$standard->id.'|max:255',
            'description' => 'required',
            'status' => 'required',
            'stt' => 'required|numeric',
            'photo' => 'mimes:jpg,png,jpeg,gif'
        ],[
                "title.required" => "Vui lòng nhập tiêu đề",
                "title.unique" => "Sản phẩm đã tồn tại",
                "title.max" => "Tên sản phẩm không quá 255 ký tự",
                "status.required" => "Vui lòng chọn trạng thái",
                "description.required" => "Vui lòng nhập mô tả",
                "stt.required" => "Vui lòng nhập số thứ tự",
                "stt.numeric" => "Trường số thứ tự phải là số",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg, png, jpeg, gif"
        ]);
       
        $standard->title = $request->title;
        $standard->status = $request->status;
        $standard->description = $request->description;
        $standard->stt = $request->stt;
        
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $pathDel = 'public/upload/images/standard/thumb/'.$standard->photo;
    
            if(file_exists($pathDel)){
                unlink($pathDel);
            }
            $file = $request->photo;
            $file_name = Str::slug(explode(".", $file->getClientOriginalName())[0], "-") . "-" . time() . "." . $file->getClientOriginalExtension();

            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_STANDARD"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);

                $image_resize->save('public/upload/images/standard/thumb/' . $file_name);
            }

            // $file->move("public/upload/images/admins/large", $file_name);
            $standard->photo = $file_name;
        }
        if($standard->save()){
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
        $data = Standard::find($id);
        $pathDel = 'public/upload/images/standard/thumb/'.$data->photo;
        
        if($data->delete()){
            if(file_exists($pathDel)){
                unlink($pathDel);
            }
            return response()->json([
                'status' => 1,
                'msg' => 'Xóa tiêu chí thành công'
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'msg' => 'Xóa tiêu chí thất bại'
            ]);
        }
    }

    public function status($id,$status)
    {
        $data = Standard::find($id);
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
            $standard = Standard::find($list_id[0]->id);
            if ($standard->delete()) {
                $pathDel = 'public/upload/images/standard/thumb/'.$standard->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
                return redirect()->route("admin.standard.index")->with(["type" => "success", "message" => "Xoá thành công!"]);
            } else {
                return back()->withInput()->with(["type" => "danger", "message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
            }
        } else {
            foreach ($list_id as $key => $value) {
                $standard = Standard::find($value->id);
                $standard->delete();
                $pathDel = 'public/upload/images/standard/thumb/'.$standard->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
            }
            return redirect()->route("admin.standard.index")->with(["type" => "success", "message" => "Xóa thành công!"]);
        }
    }
    public function resortPosition(Request $request){
        $data = $request->array_id;
        //dd($data);
        foreach ($data as $key => $value) {
            $standard = Standard::find($value);
            $standard->stt = $key;
            $standard->save();
        }

    }
}
