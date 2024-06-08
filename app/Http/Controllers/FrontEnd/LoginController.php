<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(){
        if(Auth::check()){
            return view('frontend.user.profile');
        }
        return view('frontend.login');
    }
    public function login(Request $request){
        // dd($request->all());
        $request->validate([
            'email_login'=> 'required',
            'password_login' => 'required'
        ],[
            'email_login.required' => 'Email không được trống',
            'password_login.required' => 'Mật khẩu không được trống'
        ]);
        if (Auth::attempt(['email' => $request->email_login, 'password' => $request->password_login])) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect('/admin')->with("success", "Dang nhap thanh cong");
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/login')->with('login-fail','Email hoặc mật khẩu không chính xác');
        }
    }
    public function register(Request $request){
        // dd($request->all());
        $request->validate([
            'name' => ['required'],
            'phone' => 'required',
            'email' => 'required|email|unique:pkav_users',
            'password' => 'required|min:6',
            'password-confirm' => 'required|same:password'
        ],[
            'name.required' => 'Tên không được trống',
            'phone.required' => 'Số điện thoại không được trống',
            'email.required' => 'Email đăng ký không được trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được trống',
            'password.min' => 'Mật khẩu phải nhiều hơn 6 ký tự',
            'password-confirm.required' => 'Mật khẩu nhập lại không được trống',
            'password-confirm.same' => 'Mật khẩu nhập lại không khớp'
        ]);
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->group = "customer";
        $user->created = NOW();
        $user->blocked = 'Y';
        $user->activated = 'N';
        $user->log_failed = 0;
        $user->last_visited = NOW();
        $res = $user->save();
        if($res){
            return redirect()->back()->with('register-success','Bạn đã đăng ký thành công');
        }else{
            return redirect()->back()->with('fail','Đã xảy ra lỗi');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
