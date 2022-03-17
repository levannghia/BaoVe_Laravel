<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\Config;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NhaDatController extends Controller
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
            "title" => "Quản lý nhà đất",
            "desc" => "Danh sách nhà đất"
        ]));
        $nhaDat = Products::orderBy('id','DESC')->where('type',1)->get();
        return view('admin.nhaDat.index',compact('settings','nhaDat','row'));
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
        $category = Category::where('status',1)->orderBy('id','DESC')->get();
        $row = json_decode(json_encode([
            "title" => "Thêm dự án",
            "desc" => "Thêm dự án"
        ]));
        return view('admin.nhaDat.add',compact('row' , 'settings'));
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
            'slug' => 'required|unique:products,slug|max:255',
            'area' => 'required|max:15',
            'content' => 'required',
            'status' => 'required',
            'photo' => 'required|mimes:jpg,png,jpeg,gif'
        ],[
                "category_id.required" => "Vui lòng chọn danh mục",
                "name.required" => "Vui lòng nhập tên sản phẩm",
                "name.unique" => "Sản phẩm đã tồn tại",
                "name.max" => "Tên sản phẩm không quá 255 ký tự",
                "slug.required" => "Vui lòng nhập slug",
                "slug.unique" => "Slug đã tồn tại",
                "slug.max" => "Slug không quá 255 ký tự",
                "status.required" => "Vui lòng chọn trạng thái",
                "area.required" => "Vui lòng thêm diện tích dự án",
                "area.max" => "Diện tích dự án không vượt quá 15 ký tự",
                "photo.required" => "Vui lòng thêm hình ảnh",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg,png,jpeg,gif"
        ]);

        $nhaDat = new Products;
        $nhaDat->name = $request->name;
        $nhaDat->price = $request->price;
        $nhaDat->noi_bac = 0;
        $nhaDat->type = 1;
        $nhaDat->map = $request->map;
        $nhaDat->keywords = $request->keywords;
        $nhaDat->address = $request->address;
        $nhaDat->area = $request->area;
        $nhaDat->status = $request->status;
        $nhaDat->description = $request->description;
        $nhaDat->content = $request->content;
        $nhaDat->slug = $request->slug;
        
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $file_name = Str::slug($file->getClientOriginalName(), "-") . "-" . time() . "." . $file->getClientOriginalExtension();
            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_NHA_DAT"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);
                $image_resize->save('public/upload/images/nhaDat/thumb/' . $file_name);
            }
            // close upload image
            // $file->move("upload/images/product/large/", $file_name);
            //save database
            $nhaDat->photo = $file_name;
    
        }
        if($nhaDat->save()){
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
            "title" => "Cập nhật nhà đất",
            "desc" => "Cập nhật nhà đất"
        ]));
        $nhaDat = DB::table('products')->where('id',$id)->where('type',1)->first();
        if(isset($nhaDat)){
            return view('admin.nhaDat.edit',compact('nhaDat', 'row', 'settings'));
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
        $nhaDat = Products::find($id);
        $request->validate([
            'name' => 'required|unique:products,name,'.$nhaDat->id.'|max:255',
            'slug' => 'required|unique:products,slug,'.$nhaDat->id.'|max:255',
            'area' => 'required|max:15',
            'content' => 'required',
            'status' => 'required',
            'photo' => 'mimes:jpg,png,jpeg,gif'
        ],[
                "name.required" => "Vui lòng nhập tên sản phẩm",
                "name.unique" => "Sản phẩm đã tồn tại",
                "name.max" => "Tên sản phẩm không quá 255 ký tự",
                "slug.required" => "Vui lòng nhập slug",
                "slug.unique" => "Slug đã tồn tại",
                "slug.max" => "Slug không quá 255 ký tự",
                "status.required" => "Vui lòng chọn trạng thái",
                "area.required" => "Vui lòng thêm diện tích dự án",
                "area.max" => "Diện tích dự án không vượt quá 15 ký tự",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg,png,jpeg,gif"
        ]);

       
        $nhaDat->name = $request->name;
        $nhaDat->price = $request->price;
        $nhaDat->map = $request->map;
        $nhaDat->keywords = $request->keywords;
        $nhaDat->area = $request->area;
        $nhaDat->status = $request->status;
        $nhaDat->description = $request->description;
        $nhaDat->content = $request->content;
        $nhaDat->slug = $request->slug;
        
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $pathDel = 'public/upload/images/nhaDat/thumb/'.$nhaDat->photo;
    
            if(file_exists($pathDel)){
                unlink($pathDel);
            }
            $file = $request->photo;
            $file_name = Str::slug(explode(".", $file->getClientOriginalName())[0], "-") . "-" . time() . "." . $file->getClientOriginalExtension();

            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_NHA_DAT"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);

                $image_resize->save('public/upload/images/nhaDat/thumb/' . $file_name);
            }

            // $file->move("public/upload/images/admins/large", $file_name);
            $nhaDat->photo = $file_name;
        }
        if($nhaDat->save()){
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
        $product = Products::find($id);
        $pathDel = 'public/upload/images/nhaDat/thumb/'.$product->photo;
        
        if($product->delete()){
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
        $product = Products::find($id);
        $product->noi_bac = $noiBac;
        if ($product->save()) {
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
        $product = Products::find($id);
        $product->status = $status;
        if ($product->save()) {
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
            $product = Products::find($list_id[0]->id);
            if ($product->delete()) {
                $pathDel = 'public/upload/images/nhaDat/thumb/'.$product->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
                return redirect()->route("admin.nha.dat.index")->with(["type" => "success", "message" => "Xoá thành công!"]);
            } else {
                return back()->withInput()->with(["type" => "danger", "message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
            }
        } else {
            foreach ($list_id as $key => $value) {
                $product = Products::find($value->id);
                $product->delete();
                $pathDel = 'public/upload/images/nhaDat/thumb/'.$product->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
            }
            return redirect()->route("admin.nha.dat.index")->with(["type" => "success", "message" => "Xóa thành công!"]);
        }
    }
}
