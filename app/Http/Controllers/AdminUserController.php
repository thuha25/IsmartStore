<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AdminUserController extends Controller
{   
    function __construct()
    {
        $this->middleware(function ($request,$next) {
            session(['module_active'=>'user']);
            return $next($request);
        });
    }
    function list(Request $request){
        $status = $request->input('status');
        $list_act = [
            'delete'=>'Xoá tạm thời'
        ];
        if ($status == 'trash') {
            $list_act = [
                'restore'=>'Khôi phục',
                'forceDelete'=>'Xoá vĩnh viễn'
            ];
            $users = User::onlyTrashed()->paginate(5);
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
               $keyword = $request->input('keyword');
            } 
            $users = User::with('roles')->where("name","LIKE","%{$keyword}%")->paginate(5);
        }
        $count_user_active = User::count();
        $count_user_trash =  User::onlyTrashed()->count();
        $count = [$count_user_active,$count_user_trash];
        return view('admin.user.list',compact('users','count','list_act'));
    }
    function add(){
        $roles = Role::all();
        return view('admin.user.add', ['roles' => $roles]);
    }
    function store(Request $request) {
        $request->validate(
            [
                'name' => 'required', 'string', 'max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required', 'string', 'min:8', 'confirmed',
                'password_confirmation' => 'required_with:password|same:password|min:8',
            ],
            [
                'required'=> ':attribute không được để trống',
                'max'=>':attribute có độ dài tối đa :max ký tự',
                'min'=>':attribute có độ dài tối đa :min ký tự',
                'confirmed'=>'Xác nhận lại mật khẩu không thành công',
                'required_with' => 'Xác nhận mật khẩu không được để trống khi mật khẩu có giá trị',
                'same' => 'Xác nhận mật khẩu không khớp với mật khẩu',
                'unique' => ':attribute đã tồn tại trong hệ thống',
            ],
            [
                'name' =>"Tên người dùng",
                'email' => "Email",
                'password'=>"Mật khẩu",
                'password_confirmation' => 'Xác nhận mật khẩu',
            ]
        );
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->roles()->attach($request->input('roles'));
        return redirect('admin/user/list')->with('status',"Đã thêm thành viên thành công");
    }
    function delete($id)  {
        if(Auth::id() != $id ){
            $user = User::find($id);
            $user->delete();
            return redirect('admin/user/list')->with('status',"Đã xoá thành viên thành công");
        }else{
            return redirect('admin/user/list')->with('status',"Bạn không thể tự xoá mình ra khỏi hệ thống");
        }
    }
    function action(Request $request){
        $list_check = $request->input('list_check');
        if ($list_check) {
            foreach ($list_check as $k => $id) {
                if (Auth::id() == $id) {
                    unset($list_check[$k]);
                }
            }
            if(!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with('status','Bạn đã xoá thành công');
                }
                if ($act == 'restore') {
                    User::withTrashed()
                    ->whereIn('id',$list_check)
                    ->restore();
                    return redirect('admin/user/list')->with('status','Bạn đã khôi phục thành công');
                }
                if ($act == 'forceDelete') {
                    User::withTrashed()
                    ->whereIn('id',$list_check)
                    ->forceDelete();
                    return redirect('admin/user/list')->with('status','Bạn đã xoá vĩnh viễn user thành công');
                }
            }
            return redirect('admin/user/list')->with('status','Bạn không thể thực hiện trên tài khoản của bạn');
        } else {
            return redirect('admin/user/list')->with('status','Bạn cần chọn phần tử thực hiện');
        }
    }
    function edit($id)  {
        $user = User::find($id);
        $roles = Role::all();
        return view('admin/user/edit',compact('user','roles'));
    }
    public function update(Request $request, $id) {
        $request->validate(
            [
                'name' => 'required', 'string', 'max:255',
                'password' => 'required', 'string', 'min:8', 'confirmed',
                'password_confirmation' => 'required_with:password|same:password|min:8',
            ],
            [
                'required'=> ':attribute không được để trống',
                'max'=>':attribute có độ dài tối đa :max ký tự',
                'min'=>':attribute có độ dài tối đa :min ký tự',
                'confirmed'=>'Xác nhận lại mật khẩu không thành công',
                'required_with' => 'Xác nhận mật khẩu không được để trống khi mật khẩu có giá trị',
                'same' => 'Xác nhận mật khẩu không khớp với mật khẩu',

            ],
            [
                'name' =>"Tên người dùng",
                'password'=>"Mật khẩu",
                'password_confirmation' => 'Xác nhận mật khẩu',
            ]
        );
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $user->roles()->sync($request->input('roles', []));
        return redirect('admin/user/list')->with('status',"Đã cập nhập thông tin thành công");
    }
}

