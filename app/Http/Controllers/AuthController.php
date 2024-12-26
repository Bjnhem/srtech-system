<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        return view('srtech.users.login');
    }
    function submit_login(Request $request)
    {
        // Lấy dữ liệu từ form
        $username = $request->input('username');
        $user = $username . '@gmail.com';
        $password = $request->input('password');

        // Kiểm tra tên đăng nhập trước
        $Users = User::where('email', $user)->first();
        if (!$Users) {
            // Nếu tên đăng nhập không tồn tại
            return redirect()->back()->with('error', 'Tên đăng nhập không tồn tại.');
        }

        // Kiểm tra mật khẩu
        if (!Auth::attempt(['email' => $user, 'password' => $password])) {
            // Nếu mật khẩu sai
            return redirect()->back()->with('error', 'Mật khẩu không chính xác.');
        }

        // Kiểm tra trạng thái tài khoản
        if ($Users->status == 'pending') {
            return redirect()->route('auth.signin')->with('error', 'Tài khoản chưa được phê duyệt - liên hệ Admin để phê duyệt!');
        }

        // Đăng nhập và chuyển hướng
        Auth::login($Users);
        if (Auth::user()->user_type == 'admin') {
            return redirect()->route('WareHouse.chuyen.kho');
        } else {
            return redirect()->route('WareHouse.chuyen.kho');
        }
    }



    public function signup(Request $request)
    {
        return view('srtech.users.register');
    }


    function submit_register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'part' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|confirmed|min:4',
        ]);

        // Tạo người dùng mới
        User::create([
            'username' => $request->username,
            'part' => $request->part,
            'email' => $request->username . '@gmail.com',
            'password' => Hash::make($request->password),
            'user_type' => 'user',
            'status' => 'pending',
        ]);

        // Chuyển hướng đến trang đăng nhập hoặc trang mong muốn
        return redirect()->route('auth.signin')->with('success', 'Đăng ký thành công - liên hệ Admin để phê duyệt!');
    }


    function logout()
    {
        Auth::logout();
        return redirect()->route('auth.signin')->with('success', 'Đăng xuất thành công!');
    }

    public function checkUsername(Request $request)
    {
        // Kiểm tra xem username đã tồn tại chưa
        $exists = User::where('username', $request->username)->exists();

        // Trả về phản hồi JSON
        return response()->json([
            'exists' => $exists
        ]);
    }
}
