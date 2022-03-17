<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function getProfile()
    {
        $row = json_decode(json_encode([
            "title" => "Profile",
            "desc" => "Cập nhật profile - " . Auth::user()->fullname
        ]));
        return view('admin.authentication.profile', compact('row'));
    }
    public function getLogin()
    {
        if (Auth::check()) {
            return redirect()->route("admin.dashboard.index");
        }
        return view("admin.authentication.login");
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            "username" => "required",
            "password" => "required",
        ], [
            "username.required" => "Vui lòng nhập username",
            "password.required" => "Vui lòng nhập mật khẩu",
        ]);

        $auth = array(
            'username' => $request->username,
            'password' => $request->password,
        );
        if (Auth::attempt($auth, $remember = true)) {
            return redirect()->route("admin.dashboard.index");
        } else {
            return redirect()->route("admin.login")->with(["type" => "danger", "message" => "Username hoặc mật khẩu không đúng"]);
        }
    }

    public function logout(){
        Auth::logout();
        if (!Auth::check()) {
            return redirect()->route("admin.login");
        }
    }

    public function create()
    {
        $admin = new User;
        $admin->username = "admin";
        $admin->password = Hash::make("123456");
        // $admin->type = 0; // 0 is normal, 1 is dev
        $admin->fullname = "Nghia Le";
        // $admin->gender = "1";
        // $admin->status = 0;
        $admin->remember_token = "";
        $admin->save();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ], [
            'password.required'=>'Vui lòng nhập mật khẩu',
            'confirm_password.required'=>'Vui lòng nhập xác nhận mật khẩu',
            'confirm_password.same'=>'Mật khẩu xác không chính xác',
        ]);
        if (Auth::Check()) {
            $request_data = $request->All();
            $password = auth()->user()->password;
            if (Hash::check($request_data['password'], $password)) {
                $admin_id = Auth::User()->id;
                $admin = User::find($admin_id);
                $admin->fullname = $request_data['fullname'];
                $admin->username = $request_data['username'];
                $admin->email = $request_data['email'];
                $admin->save();
                return back()->with(["type" => "success", "message" => "Lưu thành công!"]);
            } else {
                return back()->with(["type" => "danger", "message" => "Mật khẩu không chính xác."]);
            }
        }
    }

    public function changePassword(Request $request)
    {

        $this->validate($request, [
            'password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ], [
            'password.required'=>'Vui lòng nhập mật khẩu',
            'new_password.required'=>'Vui lòng nhập mật khẩu mới',
            'new_password.min'=>'Mật khẩu có ít nhất 6 ký tự',
            'confirm_password.required'=>'Vui lòng nhập xác nhận mật khẩu',
            'confirm_password.same'=>'Mật khẩu xác không chính xác',
        ]);

        if (Auth::Check()) {
            $request_data = $request->All();
            $current_password = auth()->user()->password;
            if (Hash::check($request_data['password'], $current_password)) {
                $admin_id = Auth::User()->id;
                $admin = User::find($admin_id);
                $admin->password = Hash::make($request_data['new_password']);
                $admin->save();
                return back()->with(["type" => "success", "message" => "Lưu thành công!"]);
            } else {
                return back()->with(["type" => "danger", "message" => "Mật khẩu không chính xác."]);
            }
        }
    }
}
