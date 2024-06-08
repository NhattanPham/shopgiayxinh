<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Options;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Action
        if ($request->input('task') == 'changeAction') {
            $status = $this->action($request);
            return back()->with('success',$status);
        }
        $search = $request->input('search');
        $user_group = $request->input('user_group');
        $limited = option('limit_users');
        // Get list user
        $users = User::whereAny(['name', 'email', 'phone'], 'LIKE', "%{$search}%")
                        ->where('group','LIKE',"%{$user_group}%")->paginate($limited)->withQueryString();
        return view('backend.user.list', [
            'users' => $users
        ]);
    }
     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.user.form');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('backend.user.form', [
            'user' => User::find($id)
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'group' =>['required'],
            'name' =>['required', 'string', 'max:255'],
            'phone' =>['required', 'numeric', 'min:10'],
        ],[
            'group.required' => 'Chưa chọn nhóm thành viên.',
            'name.required' => 'Họ tên không được trống.',
            'phone.required' => 'Điện thoại không được trống.',
        ]);
        if($id > 0){
            $request->validate([
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255' ,Rule::unique('pkav_users')->ignore($request->id)]
            ],[
                'email.required' => 'Email không được trống.',
                'email.unique' => 'Email đã tồn tại'
            ]);
            if($request->password != null){
                $request->validate([
                    'password' => ['confirmed', Rules\Password::defaults()],
                ], [
                    'password.confirmed' => 'Mật khẩu xác nhận không khớp.'
                ]);
            }
        }else{
            $request->validate([
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], [
                'email.required' => 'Email không được trống.',
                'email.unique' => 'Email đã tồn tại',
                'password.required' => 'Mật khẩu không được trống.',
                'password.confirmed' => 'Mật khẩu xác nhận không khớp.'
            ]);
        }
        if($id > 0){
            $user = User::find($id);
            if($request->password != null){
                $user->password = Hash::make($request->password);
            }
            $message = "Cập nhật thành viên thành công";
        }else{
            $user = new User();
            $user->password = Hash::make($request->password);
            $message = "Thêm thành viên thành công";
        }
        $user->group = $request->group;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->blocked = isset($request->blocked) ? $request->blocked : 'N';
        $user->activated = isset($request->activated) ? $request->activated : 'N';
        $user->created = NOW();
        // $user->created_by = 0;
        $user->last_visited = NOW();
        // $user->modified_by = 0;
        $user->log_failed = 0;
        $user->save();
        if($request->input('action') == 'save'){
            return redirect('admin/users')->with("success", $message);
        }else if($request->input("action") == "update"){
            return back()->with("success", $message);
        }
    }
    /**
     * Make action and return status
     */
    public function action(Request $request){
        $status ='';
        $ids = $request->input('ids');
        switch ($request->input('action')) {
            case 'activated':
                User::whereIn('id',$ids)->update(['activated' => 'Y']);
                $status = "Kích hoạt tài khoản thành công";
                break;
            case 'blocked':
                User::whereIn('id',$ids)->update(['blocked' => 'Y']);
                $status = "Đã khóa tài khoản";
                break;
            case 'unlocked':
                User::whereIn('id',$ids)->update(['blocked' => 'N']);
                $status = "Đã mở khóa tài khoản";
                break;
            case 'delete':
                User::whereIn('id', $ids)->delete();
                $status = "Xóa thành công";
                break;
            default:
                break;
        }
        return $status;
    }
    /**
     * Block or unlock user
     */
    public function blocked($id){
        $user = User::find($id);
        $user->blocked = ($user->blocked == 'Y')?'N':'Y';
        $user->save();
        return back();
    }
}
