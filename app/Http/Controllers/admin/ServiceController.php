<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Config;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ServiceTranslation;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = Service::orderBy('id','DESC')->get();
        $row = json_decode(json_encode([
            "title" => "Service",
            "desc" => "Dịch vụ"
        ]));
        return view("admin.service.index",compact('service','row'));
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
            "title" => "Create service",
            "desc" => "Thêm dịch vụ"
        ]));
        return view("admin.service.add",compact('row','settings'));
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
            'slug' => 'required|unique:services,slug|max:255',
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

        $service = new Service;
        
        $service->fill([
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

        $service->noi_bac = 0;
        $service->keywords = $request->keywords;
        $service->status = $request->status;
        $service->slug = $request->slug;
        
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $file_name = Str::slug($file->getClientOriginalName(), "-") . "-" . time() . "." . $file->getClientOriginalExtension();
            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_SERVICE"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);
                $image_resize->save('public/upload/images/service/thumb/' . $file_name);
            }
            $service->photo = $file_name;
    
        }
        if($service->save()){
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
        $service_vi = Service::join('service_translations','service_translations.service_id','=','services.id')
        ->where('service_translations.service_id',$id)->where('service_translations.locale','vi')->first();
        $service_en = Service::join('service_translations','service_translations.service_id','=','services.id')
        ->where('service_translations.service_id',$id)->where('service_translations.locale','en')->first();
        $row = json_decode(json_encode([
            "title" => "Update service",
            "desc" => "Chỉnh sửa dịch vụ: " . $service_vi->title
        ]));

        return view("admin.service.edit",compact('service_vi','service_en','row', 'settings'));
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
        $service = Service::find($id);
        $request->validate([
            'slug' => 'required|unique:news,slug,'.$service->id.'|max:255',
            'status' => 'required',
            'photo' => 'mimes:jpg,png,jpeg,gif'
        ],[
                "slug.required" => "Vui lòng nhập slug",
                "slug.unique" => "Slug đã tồn tại",
                "slug.max" => "Slug không quá 255 ký tự",
                "status.required" => "Vui lòng chọn trạng thái",
                "photo.mimes" => "Chọn đúng đinh dạng hình ảnh: jpg, png, jpeg, gif"
        ]);
       
        $service->status = $request->status;
        $service->keywords = $request->keywords;
        $service->slug = $request->slug;
        $service->fill([
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
        
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $pathDel = 'public/upload/images/service/thumb/'.$service->photo;
    
            if(file_exists($pathDel)){
                unlink($pathDel);
            }
            $file = $request->photo;
            $file_name = Str::slug(explode(".", $file->getClientOriginalName())[0], "-") . "-" . time() . "." . $file->getClientOriginalExtension();

            //resize file befor to upload large
            if ($file->getClientOriginalExtension() != "svg") {
                $image_resize = Image::make($file->getRealPath());
                $thumb_size = json_decode($settings["THUMB_SIZE_SERVICE"]);
                $image_resize->fit($thumb_size->width,$thumb_size->height);

                $image_resize->save('public/upload/images/service/thumb/' . $file_name);
            }

            // $file->move("public/upload/images/admins/large", $file_name);
            $service->photo = $file_name;
        }
        if($service->save()){
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
        $data = Service::find($id);
        $pathDel = 'public/upload/images/service/thumb/'.$data->photo;
        
        if($data->delete()){
            if(file_exists($pathDel)){
                unlink($pathDel);
            }
            return response()->json([
                'status' => 1,
                'msg' => 'Xóa dịch vụ thành công'
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'msg' => 'Xóa dịch vụ thất bại'
            ]);
        }
    }

    public function noiBac($id,$noiBac)
    {
        $data = Service::find($id);
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
        $data = Service::find($id);
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
            $service = Service::find($list_id[0]->id);
            if ($service->delete()) {
                $pathDel = 'public/upload/images/service/thumb/'.$service->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
                return redirect()->route("admin.service.index")->with(["type" => "success", "message" => "Xoá thành công!"]);
            } else {
                return back()->withInput()->with(["type" => "danger", "message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
            }
        } else {
            foreach ($list_id as $key => $value) {
                $service = Service::find($value->id);
                $service->delete();
                $pathDel = 'public/upload/images/service/thumb/'.$service->photo;
                if(file_exists($pathDel)){
                    unlink($pathDel);
                }
            }
            return redirect()->route("admin.service.index")->with(["type" => "success", "message" => "Xóa thành công!"]);
        }
    }
}
