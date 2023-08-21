<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminPermissionController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'role']);
            return $next($request);
        });
    }
    function add() {
        $permissions = Permission::all()->groupBy(function ($permission)  {
            return explode('.',$permission->slug)[0];
        });
        return view('admin.permission.add',compact('permissions'));
    }
    function store(Request $request)  {
        $request->validate(
            [
                'name'=>'required|max:255',
                'slug'=>'required'
            ],
            [
                'required'=>':attribute không được để trống',
            ],
            [
                'name' => 'Tiêu đề',
                'slug'=>'Slug'
            ]

        );
        Permission::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'), 
            'description' => $request->input('description'), 
        ]);  
        return redirect()->route('admin.permission.add')->with('success',"Đã thêm quyền thành công");   
    }
    function edit($id)  {
        $permissions = Permission::all()->groupBy(function ($permission)  {
            return explode('.',$permission->slug)[0];
        });
        $permission = Permission::find($id);
        return view('admin.permission.edit',compact('permissions','permission'));
    }
    function update(Request $request,$id)  {
        $request->validate(
            [
                'name'=>'required|max:255',
                'slug'=>'required'
            ],
            [
                'required'=>':attribute không được để trống',
            ],
            [
                'name' => 'Tiêu đề',
                'slug'=>'Slug'
            ]
        );
        Permission::where('id',$id)->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'), 
            'description' => $request->input('description'), 
        ]); 
        return redirect()->route('admin.permission.add')->with('success',"Đã chỉnh sửa thành công");   
    }
    function delete($id)  {
        Permission::where('id',$id)->delete();
        return redirect()->route('admin.permission.add')->with('success',"Đã xoá quyền thành công"); 
    }
}
