<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\Config;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
// use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
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
            "title" => "Product",
            "desc" => "Danh sách sản phẩm"
        ]));
        $product = Products::select('products.slug', 'products.photo' ,'products.id', 'products.name','products.status', 'products.noi_bac', 'products.created_at', 'products.price', 'categories.name AS category_name')
        ->join('categories','categories.id','=','products.category_id')->where('type',0)->orderBy('products.id','DESC')->get();
        return view('admin.product.index',compact('settings','product','row'));
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
            "title" => "Create product",
            "desc" => "Thêm sản phẩm"
        ]));
        return view('admin.product.add',compact('row','category', 'settings'));
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
            'category_id' => 'required',
            'description' => 'required',
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
                "description.required" => "Vui lòng nhập nội dung",
                "photo.required" => "Vui lòng thêm hình ảnh",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg,png,jpeg,gif"
        ]);

        $product = new Products;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->noi_bac = 0;
        $product->type = 0;
        $product->content = $request->content;
        $product->keywords = $request->keywords;
        $product->status = $request->status;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->slug = $request->slug;
        
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $file_name = Str::slug($file->getClientOriginalName(), "-") . "-" . time() . "." . $file->getClientOriginalExtension();
            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_PRODUCT"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);
                $image_resize->save('public/upload/images/product/thumb/' . $file_name);
            }
            // close upload image
            // $file->move("upload/images/product/large/", $file_name);
            //save database
            $product->photo = $file_name;
    
        }
        if($product->save()){
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
            "title" => "Update product",
            "desc" => "Cập nhật sản phẩm"
        ]));
        $category = Category::where('status',1)->orderBy('id','DESC')->get();
        $product = DB::table('products')->where('id',$id)->where('type',0)->first();;
        if(isset($product)){
            return view('admin.product.edit',compact('product', 'category', 'row', 'settings'));
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
        $product = Products::find($id);
        $this->validate($request, [
            'name' => 'required|unique:products,name,'.$product->id.'|max:255',
            'slug' => 'required|unique:products,slug, '.$product->id.'|max:255',
            'category_id' => 'required',
            'status' => 'required',
            'photo' => 'mimes:jpg,png,jpeg,gif'
        ],[
            "category_id.required" => "Vui lòng chọn danh mục",
            "name.required" => "Vui lòng nhập tên sản phẩm",
            "name.unique" => "Sản phẩm đã tồn tại",
            "name.max" => "Tên sản phẩm không quá 255 ký tự",
            "slug.required" => "Vui lòng nhập slug",
            "slug.unique" => "Slug đã tồn tại",
            "slug.max" => "Slug không quá 255 ký tự",
            "status.required" => "Vui lòng chọn trạng thái",
            "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg,png,jpeg,gif"
        ]);

       
        $product->name = $request->name;
        $product->status = $request->status;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->slug = $request->slug;
        $product->content = $request->content;
        
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $pathDel = 'public/upload/images/product/thumb/'.$product->photo;
    
            if(file_exists($pathDel)){
                unlink($pathDel);
            }
            $file = $request->photo;
            $file_name = Str::slug(explode(".", $file->getClientOriginalName())[0], "-") . "-" . time() . "." . $file->getClientOriginalExtension();

            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_PRODUCT"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);

                $image_resize->save('public/upload/images/product/thumb/' . $file_name);
            }

            // $file->move("public/upload/images/admins/large", $file_name);
            $product->photo = $file_name;
        }
        if($product->save()){
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
        $pathDel = 'public/upload/images/product/thumb/'.$product->photo;
        
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
                $pathDel = 'public/upload/images/product/thumb/'.$product->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
                return redirect()->route("admin.product.index")->with(["type" => "success", "message" => "Xoá thành công!"]);
            } else {
                return back()->withInput()->with(["type" => "danger", "message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
            }
        } else {
            foreach ($list_id as $key => $value) {
                $product = Products::find($value->id);
                $product->delete();
                $pathDel = 'public/upload/images/product/thumb/'.$product->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
            }
            return redirect()->route("admin.product.index")->with(["type" => "success", "message" => "Xóa thành công!"]);
        }
    }
}
