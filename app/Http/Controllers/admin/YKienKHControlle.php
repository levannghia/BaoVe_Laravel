<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Review;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class YKienKHControlle extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $row = json_decode(json_encode([
            "title" => "Review",
            "desc" => "Ý kiến khách hàng"
        ]));
        $review = Review::orderBy('id','DESC')->get();
        return view('admin.yKien.index',compact('settings','review','row'));
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
            "title" => "Create review",
            "desc" => "Thêm ý kiến khách hàng"
        ]));
        return view('admin.yKien.add',compact('row', 'settings'));
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
            'name' => 'required|unique:products,name|max:255',
            'status' => 'required',
            'photo' => 'required|mimes:jpg,png,jpeg,gif'
        ],[
                "name.required" => "Vui lòng nhập tên sản phẩm",
                "name.unique" => "Sản phẩm đã tồn tại",
                "name.max" => "Tên sản phẩm không quá 255 ký tự",
                "status.required" => "Vui lòng chọn trạng thái",
                "photo.required" => "Vui lòng thêm hình ảnh",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg,png,jpeg,gif"
        ]);

        $review = new Review;
        $review->name = $request->name;
        $review->address = $request->address;
        $review->noi_bac = 0;
        $review->status = $request->status;
        $review->description = $request->description;
        
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $file_name = Str::slug($file->getClientOriginalName(), "-") . "-" . time() . "." . $file->getClientOriginalExtension();
            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_REVIEW"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);
                $image_resize->save('public/upload/images/yKien/thumb/' . $file_name);
            }
            // close upload image
            // $file->move("upload/images/product/large/", $file_name);
            //save database
            $review->photo = $file_name;
    
        }
        if($review->save()){
            return redirect()->back()->with(["type"=>"success","message"=>"Thêm sản phẩm thành công"]);
        }else{
            return back()->withInput()->with(["type"=>"danger","message"=>"Thêm sản phẩm thất bại"]);
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

        $row = json_decode(json_encode([
            "title" => "Update review",
            "desc" => "Cập nhật ý kiến khách hàng"
        ]));
        $review = DB::table('reviews')->where('id',$id)->first();;
        if(isset($review)){
            return view('admin.yKien.edit',compact('review', 'row', 'settings'));
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
        $review = Review::find($id);
        $this->validate($request, [
            'name' => 'required|max:255',
            'status' => 'required',
            'photo' => 'mimes:jpg,png,jpeg,gif'
        ],[
            "name.required" => "Vui lòng nhập tên sản phẩm",
            "status.required" => "Vui lòng chọn trạng thái",
            "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg,png,jpeg,gif"
        ]);

       
        $review->name = $request->name;
        $review->status = $request->status;
        $review->description = $request->description;
        $review->address = $request->address;
        
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $pathDel = 'public/upload/images/yKien/thumb/'.$review->photo;
    
            if(file_exists($pathDel)){
                unlink($pathDel);
            }
            $file = $request->photo;
            $file_name = Str::slug(explode(".", $file->getClientOriginalName())[0], "-") . "-" . time() . "." . $file->getClientOriginalExtension();

            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_REVIEW"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);

                $image_resize->save('public/upload/images/yKien/thumb/' . $file_name);
            }

            // $file->move("public/upload/images/admins/large", $file_name);
            $review->photo = $file_name;
        }
        if($review->save()){
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
        $review = Review::find($id);
        $pathDel = 'public/upload/images/yKien/thumb/'.$review->photo;
        
        if($review->delete()){
            if(file_exists($pathDel)){
                unlink($pathDel);
            }
            return response()->json([
                'status' => 1,
                'msg' => 'Xóa sản phẩm thành công'
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'msg' => 'Xóa sản phẩm thất bại'
            ]);
        }
    }

    public function noiBac($id,$noiBac)
    {
        $review = Review::find($id);
        $review->noi_bac = $noiBac;
        if ($review->save()) {
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
        $review = Review::find($id);
        $review->status = $status;
        if ($review->save()) {
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
            $review = Review::find($list_id[0]->id);
            if ($review->delete()) {
                $pathDel = 'public/upload/images/yKien/thumb/'.$review->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
                return redirect()->route("admin.y.kien.index")->with(["type" => "success", "message" => "Xoá thành công!"]);
            } else {
                return back()->withInput()->with(["type" => "danger", "message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
            }
        } else {
            foreach ($list_id as $key => $value) {
                $review = Review::find($value->id);
                $review->delete();
                $pathDel = 'public/upload/images/yKien/thumb/'.$review->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
            }
            return redirect()->route("admin.y.kien.index")->with(["type" => "success", "message" => "Xóa thành công!"]);
        }
    }
}
