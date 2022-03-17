<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Str;
use App\Models\Products;
use App\Models\Config;
use Intervention\Image\ImageManagerStatic as Image;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $product = Products::find($id);
        if(isset($product)){
            $row = json_decode(json_encode([
                "title" => "Gallery - " . $product->name,
                "desc" => "Gallery - " . $product->name
            ]));
            $gallery = Gallery::select('galleries.photo', 'galleries.id', 'galleries.created_at', 'galleries.updated_at', 'galleries.stt','galleries.status')
                ->join('products', 'products.id', '=', 'galleries.product_id')->where('galleries.product_id', $id)->orderBy('galleries.stt', 'ASC')->get();
            return view('admin.gallery.index', compact('gallery', 'row', 'product'));
        }
        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $product = Products::find($id);
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        if(isset($product)){
            $row = json_decode(json_encode([
                "title" => "Create gallery - " . $product->name,
                "desc" => "Thêm gallery - " . $product->name
            ]));
            return view('admin.gallery.add', compact('row', 'product', 'settings'));
        }
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            "photo" => "required",
        ],[
            "photo.required" => "Vui lòng chọn hình ảnh",
            //"photo.image" => "file update lên phải là hình ảnh"
        ]);
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();

        // $product = Products::find($id);
        // if($product->type == 0){
        //     $thumb_size = json_decode($settings["THUMB_SIZE_GALLERY"]);
        // }elseif($product->type == 1){
        //     $thumb_size = json_decode($settings["THUMB_SIZE_GALLERY_NHA_DAT"]);
        // }
        $get_image = $request->photo;
        $i = 0;
        if ($request->hasFile('photo')) {
            foreach ($get_image as $item) {
                $gallery = new Gallery;
                $get_fileName = Str::slug(explode(".", $item->getClientOriginalName())[0], "-") . "-" . time() . "." . $item->getClientOriginalExtension();
                if ($item->getClientOriginalExtension() != "svg") {
                    $image_resize = Image::make($item->getRealPath());
                    $thumb_size = json_decode($settings["THUMB_SIZE_GALLERY"]);
                    $image_resize->fit($thumb_size->width, $thumb_size->height);
                    $image_resize->save('public/upload/images/gallery/thumb/' . $get_fileName);
                    // $images[] = $get_fileName;     
                }
                $gallery->product_id = $id;
                $gallery->status = 1;
                $gallery->photo = $get_fileName;
                $gallery->stt = $i++;
                $gallery->save();
                // $item->move('upload/images/product/thumb/', $get_fileName);
                // $images[] = $get_fileName;
            }
                return redirect()->route('admin.gallery.index',$id)->with(["type"=>"success","message"=>"Thêm gallery thành công"]);
        }
        return back()->withInput()->with(["type"=>"danger","message"=>"Thêm gallery thất bại"]);
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
        $gallery = Gallery::find($id);

        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        if(isset($gallery)){
            $row = json_decode(json_encode([
                "title" => "Update gallery",
                "desc" => "Cập nhật gallery"
            ]));
            
            return view('admin.gallery.edit',compact('settings','gallery','row'));
        }
        abort(404);
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
        $this->validate($request, [
            'photo' => 'mimes:jpg,png,jpeg,gif'
        ],[
            "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg, png, jpeg, gif"
        ]);
        $settings = Config::all(['name', 'value'])->keyBy('name')->transform(function ($setting) {
            return $setting->value; // return only the value
        })->toArray();
        $gallery = Gallery::find($id);
        
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $pathDel = 'public/upload/images/gallery/thumb/'.$gallery->photo;
    
            if(file_exists($pathDel)){
                unlink($pathDel);
            }

            $file_name = Str::slug(explode(".", $file->getClientOriginalName())[0], "-") . "-" . time() . "." . $file->getClientOriginalExtension();

            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_GALLERY"]);  
                $image_resize->fit($thumb_size->width,$thumb_size->height);

                $image_resize->save('public/upload/images/gallery/thumb/' . $file_name);
            }

            // $file->move("public/upload/images/admins/large", $file_name);
            $gallery->photo = $file_name;
        }
        if($gallery->save()){
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
        $gallery = Gallery::find($id);
        if($gallery->delete()){
            return response()->json([
                'status' => 1,
                'msg' => 'Xóa hình ảnh thành công'
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'msg' => 'Xóa hình ảnh thất bại'
            ]);
        }
    }

    public function status($id,$status)
    {
        $gallery = Gallery::find($id);
        $gallery->status = $status;
        if ($gallery->save()) {
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
            $gallery = Gallery::find($list_id[0]->id);
            if ($gallery->delete()) {
                $pathDel = 'public/upload/images/gallery/thumb/'.$gallery->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
                return redirect()->back()->with(["type" => "success", "message" => "Xoá thành công!"]);
            } else {
                return back()->withInput()->with(["type" => "danger", "message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
            }
        } else {
            foreach ($list_id as $key => $value) {
                $gallery = Gallery::find($value->id);
                $gallery->delete();
                $pathDel = 'public/upload/images/gallery/thumb/'.$gallery->photo;
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
            $gallery = Gallery::find($value);
            $gallery->stt = $key;
            $gallery->save();
        }

    }
}
