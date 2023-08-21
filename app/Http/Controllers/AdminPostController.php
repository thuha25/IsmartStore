<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatPost;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
class AdminPostController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request,$next) {
            session(['module_active'=>'post']);
            return $next($request);
        });
    }
    function add(){
        $cat_posts = DB::table('cat_posts')->get();
        return view('admin.post.add',compact('cat_posts'));
    }
    function list(Request $request)  {
        $status = $request->input('status');
        $list_act = [
            'delete'=>'Xoá tạm thời'
        ];
        if ($status === 'trash') {
            $list_act = [
                'restore'=>'Khôi phục',
                'forceDelete'=>'Xoá vĩnh viễn'
            ];
            $posts = Post::onlyTrashed()->paginate(10);
        }else{
            $keyword = "";
            if($request->input('keyword')){
                $keyword =  $request->input('keyword');
            }
            $posts = Post::where("title","LIKE","%{$keyword}%")->paginate(10);
        }
        $count_posts_all = Post::withTrashed()->count();
        $count_posts_trash = Post::onlyTrashed()->count();
        $count = [$count_posts_all,$count_posts_trash];
        return view('admin/post/list',compact('posts','count','list_act'));
    }
    function listCat()  {
        $posts = DB::table('cat_posts')->get();
        return view('admin.post.listCat', compact('posts'));
    }
    function storeCat(Request $request){
        $request->validate(
            [
                'name'=>'required',
                'parent_cat'=>'required'
            ],
            [
                'required'=>':attribute không được để trống',
            ],
            [
                'name' => 'Tiêu đề',
                'parent_cat'=>'Danh mục'
            ]

        );
        try {
            $data = [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'), 
                'state' => $request->input('state'), 
                'parent_cat' => $request->input('parent_cat'), 
                'created_at'=> now()
            ];
            DB::table('cat_posts')->insert($data);
            return redirect()->route('admin.post.listCat')->with('success', 'Danh mục đã được thêm thành công!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('admin.post.listCat')->with('error', 'Lỗi: Danh mục đã tồn tại!');
            } else {
                return redirect()->route('admin.post.listCat')->with('error', 'Lỗi: Không thể thêm danh mục!');
            }
        }
    }
    function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'post_thumb' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'categories_selector' => 'required|array|min:1', 
        ], 
        [
            'required' => ':attribute không được để trống.',
            'image' => 'Ảnh bìa phải là hình ảnh.',
            'mimes' => 'Ảnh bìa phải có định dạng jpeg, png, jpg.',
            'max' => 'Kích thước ảnh bìa không được vượt quá 2MB.',
            'min' => 'Phải chọn ít nhất một danh mục.',
        ],
        [
            'title' => 'Tiêu đề bài viết',
            'slug' => 'Slug link rút gọn',
            'post_thumb' => 'Ảnh bìa bài viết',
            'categories_selector' => 'Danh mục',
            'content' => 'Nội dung bài viết',
        ]);

        if ($request->hasFile('post_thumb')) {
            $thumbnail = $request->file('post_thumb');
            $thumbnailName = $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('images/thumbnails'), $thumbnailName);
        }
        $data = [
        'title' => $request->input('title'),
        'slug' => $request->input('slug'),
        'content' => $request->input('content'),
        'state' => $request->input('state'),
        'created_at' => now(),
        ];
        if (isset($thumbnailName)) {
            $data['thumbnail_path'] = 'images/thumbnails/' . $thumbnailName;
        }
        $post = Post::create($data);
        $categoriesIds = $request->input('categories_selector');
        $post->categories()->attach($categoriesIds);
        return redirect()->route('admin.post.list')->with('success', 'Bài viết đã được thêm thành công!');

    }
    function action(Request $request){
        $list_check = $request->input('list_check');
        if ($list_check) {
            $act = $request->input('act');
            if ($act == 'delete') {
                Post::destroy($list_check);
                return redirect('admin/post/list')->with('success','Bạn đã xoá thành công');
            }
            if ($act == 'restore') {
                Post::withTrashed()
                ->whereIn('id',$list_check)
                ->restore();
                return redirect('admin/post/list')->with('success','Bạn đã khôi phục thành công');
            }
            if ($act == 'forceDelete') {
                Post::withTrashed()
                ->whereIn('id',$list_check)
                ->forceDelete();
                return redirect('admin/post/list')->with('success','Bạn đã xoá trang thành công');
            }
        } else {
            return redirect('admin/post/list')->with('success','Bạn cần chọn phần tử thực hiện');
        }
    }
    function editCat($id) {
        $posts = DB::table('cat_posts')->get();
        $cat_posts = CatPost::find($id) ;
        return view('admin.post.editCat',compact('cat_posts','posts'));
    }
    function editPost($id) {
        $cat_posts = DB::table('cat_posts')->get();
        $posts = Post::find($id) ;
        $categories = $posts->categories; 
        return view('admin.post.editPost',compact('cat_posts', 'posts','categories'));
    }
    function updateCat(Request $request, $id){
        $request->validate(
            [
                'name'=>'required',
                'parent_cat'=>'required'
            ],
            [
                'required'=>':attribute không được để trống',
            ],
            [
                'name' => 'Tiêu đề',
                'parent_cat'=>'Danh mục'
            ]
        );
        CatPost::where('id', $id)->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'), 
            'state' => $request->input('state'), 
            'parent_cat' => $request->input('parent_cat'), 
            'created_at'=> now()
        ]);
       return redirect('admin/post/cat/list')->with('success',"Đã cập nhập thông tin thành công");
    }
    function updatePost(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'post_thumb' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories_selector' => 'required|array|min:1', 
        ], 
        [
            'required' => ':attribute không được để trống.',
            'image' => 'Ảnh bìa phải là hình ảnh.',
            'mimes' => 'Ảnh bìa phải có định dạng jpeg, png, jpg.',
            'max' => 'Kích thước ảnh bìa không được vượt quá 2MB.',
            'min' => 'Phải chọn ít nhất một danh mục.',
        ],
        [
            'title' => 'Tiêu đề bài viết',
            'slug' => 'Slug link rút gọn',
            'post_thumb' => 'Ảnh bìa bài viết',
            'categories_selector' => 'Danh mục',
            'content' => 'Nội dung bài viết',
        ]);
        $data = [
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'content' => $request->input('content'),
            'state' => $request->input('state'),
            'created_at' => now(),
        ];
        if ($request->hasFile('post_thumb')) {
            $thumbnail = $request->file('post_thumb');
            $thumbnailName = $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('images/thumbnails'), $thumbnailName);
            $data['thumbnail_path'] = 'images/thumbnails/' . $thumbnailName;        
        }
        Post::where('id', $id)->update($data);
        $categoriesIds = $request->input('categories_selector');
        $post = Post::findOrFail($id);
        $post->categories()->sync($categoriesIds);
        return redirect('admin/post/list')->with('success',"Đã cập nhập thông tin thành công");
    }
    function delete($id) {
        $cat_posts = CatPost::find($id);
        $cat_posts->delete();
        return redirect()->route('admin.post.listCat')->with('success', 'Danh mục đã được xoá thành công!');
    }
    function deletePost($id) {
        $posts = Post::find($id);
        $posts->delete();
        return redirect()->route('admin.post.list')->with('success', 'Danh mục đã được xoá thành công!');
    }
}
