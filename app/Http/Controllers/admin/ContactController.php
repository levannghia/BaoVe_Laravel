<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $row = json_decode(json_encode([
            "title" => "Contact",
            "desc" => "Liên hệ",
        ]));
        $contact = Contact::orderBy('id','DESC')->get();
        return view('admin.contact.index',compact('contact','row'));
    }

    public function edit($id){
        $contact = Contact::find($id);
        $row = json_decode(json_encode([
            "title" => "Update contact",
            "desc" => "Liên hệ: " . $contact->name,
        ]));
        return view('admin.contact.edit',compact('contact','row'));
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
       
        $contact->name = $request->name;
        $contact->status = $request->status;
        $contact->note = $request->note;
        $contact->content = $request->content;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->address = $request->address;
        
        if($contact->save()){
            return redirect()->back()->with(["type"=>"success","message"=>"Cập nhật thành công"]);
        }else{
            return back()->withInput()->with(["type"=>"danger","message"=>"Cập nhật thất bại"]);
        }
    }

    public function destroy($id)
    {
        $data = Contact::find($id);
        // $pathDel = 'upload/images/news/thumb/'.$data->photo;
        
        if($data->delete()){
            // if(file_exists($pathDel)){
            //     unlink($pathDel);
            // }
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

    // public function noiBac($id,$noiBac)
    // {
    //     $data = News::find($id);
    //     $data->noi_bac = $noiBac;
    //     if ($data->save()) {
    //         return response()->json([
    //             "status" => 1,
    //             "msg" => "cập nhật thành công"
    //         ]);
    //     } else {
    //         return response()->json([
    //             "status" => 0,
    //             "msg" => "cập nhật thất bại"
    //         ]);
    //     }
    // }

    public function status($id,$status)
    {
        $data = Contact::find($id);
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
            $news = Contact::find($list_id[0]->id);
            if ($news->delete()) {
                // $pathDel = 'upload/images/news/thumb/'.$news->photo;
                // if(file_exists($pathDel)){
                //     unlink($pathDel);
                // }
                return redirect()->route("admin.contact.index")->with(["type" => "success", "message" => "Xoá thành công!"]);
            } else {
                return back()->withInput()->with(["type" => "danger", "message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
            }
        } else {
            foreach ($list_id as $key => $value) {
                $news = Contact::find($value->id);
                $news->delete();
                // $pathDel = 'upload/images/news/thumb/'.$news->photo;
                // if(file_exists($pathDel)){
                //     unlink($pathDel);
                // }
            }
            return redirect()->route("admin.contact.index")->with(["type" => "success", "message" => "Xóa thành công!"]);
        }
    }
}
