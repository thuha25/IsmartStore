<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminPageController extends Controller
{

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
    }
    function list(Request $request)
    {
        $status = $request->input('status');
        $list_act = [
            'delete' => 'Xoá tạm thời'
        ];
        if ($status === 'trash') {
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
            $pages = Page::onlyTrashed()->paginate(5);
        } else if ($status === 'public') {
            $pages = Page::where('state', 'Công khai')->paginate(5);
        } else if ($status ===  'pending') {
            $pages = Page::where('state', 'Chờ duyệt')->paginate(5);
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword =  $request->input('keyword');
            }
            $pages = Page::where("name_page", "LIKE", "%{$keyword}%")->paginate(5);
        }
        $count_pages_all = Page::count();
        $count_pages_public = Page::where('state', 'Công khai')->count();
        $count_pages_pending = Page::where('state', 'Chờ duyệt')->count();
        $count_pages_trash = Page::onlyTrashed()->count();
        $count = [$count_pages_all, $count_pages_public, $count_pages_pending, $count_pages_trash];
        return view('admin/page/list', compact('pages', 'count', 'list_act'));
    }
    function add()
    {
        return view('admin.page.add');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',
                'name_page' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'name_page' => 'Tên trang'
            ]
        );
        $data = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'name_page' => $request->input('name_page'),
            'slug' => $request->input('slug'),
            'state' => $request->input('state'),
            'user_id' => auth()->user()->id,
            'created_by' => auth()->user()->name,
            'created_at' => now()
        ];

        DB::table('pages')->insert($data);
        return redirect()->route('admin.page.list')->with('success', 'Trang đã được thêm thành công!');
    }
    function delete($id)
    {
        $page = Page::find($id);
        $page->delete();
        return redirect()->route('admin.page.list')->with('success', 'Trang đã được xoá thành công!');
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            $act = $request->input('act');
            if ($act == 'delete') {
                Page::destroy($list_check);
                return redirect('admin/page/list')->with('success', 'Bạn đã xoá thành công');
            }
            if ($act == 'restore') {
                Page::withTrashed()
                    ->whereIn('id', $list_check)
                    ->restore();
                return redirect('admin/page/list')->with('success', 'Bạn đã khôi phục thành công');
            }
            if ($act == 'forceDelete') {
                Page::withTrashed()
                    ->whereIn('id', $list_check)
                    ->forceDelete();
                return redirect('admin/page/list')->with('success', 'Bạn đã xoá trang thành công');
            }
        } else {
            return redirect('admin/page/list')->with('success', 'Bạn cần chọn phần tử thực hiện');
        }
    }
    function edit($id)
    {
        $page = Page::find($id);
        return view('admin/page/edit', compact('page'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',
                'name_page' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'name_page' => 'Tên trang'
            ]
        );
        Page::where('id', $id)->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'name_page' => $request->input('name_page'),
            'slug' => $request->input('slug'),
            'state' => $request->input('state'),
            'user_id' => auth()->user()->id,
            'created_by' => auth()->user()->name,
            'created_at' => now()
        ]);

        return redirect('admin/page/list')->with('success', "Đã cập nhập thông tin thành công");
    }
}
