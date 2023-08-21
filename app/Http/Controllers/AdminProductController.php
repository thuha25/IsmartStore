<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CatProduct;
use App\Models\BrandProduct;
use App\Models\ColorProduct;
use App\Models\Product;
use App\Models\ProductImage;

class AdminProductController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }
    function list(Request $request)
    {
        $status = $request->input('status');
        $list_act = [
            'stocking' => 'Còn hàng',
            'outofstock' => 'Hết hàng',
            'delete' => 'Xoá tạm thời'
        ];
        if ($status === 'trash') {
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
            $products = Product::onlyTrashed()->paginate(10);
        } else if ($status === 'stocking') {
            $products = Product::where('status', 'Còn hàng')->paginate(10);
        } else if ($status ===  'outofstock') {
            $products = Product::where('status', 'Hết hàng')->paginate(10);
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword =  $request->input('keyword');
            }
            $products = Product::where("product_name", "LIKE", "%{$keyword}%")->paginate(10);
        }
        $count_product_all = Product::count();
        $count_product_stocking = Product::where('status', 'Còn hàng')->count();
        $count_product_outofstock = Product::where('status', 'Hết hàng')->count();
        $count_product_trash = Product::onlyTrashed()->count();
        $count = [$count_product_all, $count_product_stocking, $count_product_outofstock, $count_product_trash];
        return view('admin/product/list', compact('products', 'count', 'list_act'));
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            $act = $request->input('act');
            if ($act == 'delete') {
                Product::destroy($list_check);
                return redirect('admin/product/list')->with('success', 'Bạn đã xoá thành công');
            }
            if ($act == 'stocking') {
                $newStatus = 'Còn hàng';
                $productsToUpdate = Product::whereIn('id', $list_check)->where('status', '!=', $newStatus);
                $updatedCount = $productsToUpdate->update(['status' => $newStatus]);

                if ($updatedCount > 0) {
                    return redirect('admin/product/list')->with('success', 'Bạn đã đổi trạng thái thành công');
                } else {
                    return redirect('admin/product/list');
                }
            }
            if ($act == 'outofstock') {
                $newStatus = 'Hết hàng';
                $productsToUpdate = Product::whereIn('id', $list_check)->where('status', '!=', $newStatus);
                $updatedCount = $productsToUpdate->update(['status' => $newStatus]);

                if ($updatedCount > 0) {
                    return redirect('admin/product/list')->with('success', 'Bạn đã đổi trạng thái thành công');
                } else {
                    return redirect('admin/product/list');
                }
            }
            if ($act == 'restore') {
                Product::withTrashed()
                    ->whereIn('id', $list_check)
                    ->restore();
                return redirect('admin/product/list')->with('success', 'Bạn đã khôi phục thành công');
            }
            if ($act == 'forceDelete') {
                Product::withTrashed()
                    ->whereIn('id', $list_check)
                    ->forceDelete();
                return redirect('admin/product/list')->with('success', 'Bạn đã xoá trang thành công');
            }
        } else {
            return redirect('admin/product/list')->with('success', 'Bạn cần chọn phần tử thực hiện');
        }
    }
    function editProduct($id)
    {
        $colors = ColorProduct::all();
        $products = Product::find($id);
        $categories = $products->category;
        $colorsSelected = $products->colors;
        $brands = $products->brands;
        return view('admin.product.editProduct', compact('products', 'colors', 'categories', 'brands', 'colorsSelected'));
    }
    function add()
    {
        $colors = ColorProduct::all();
        $categories = CatProduct::all();
        $brands = BrandProduct::all();
        return view('admin.product.add', [
            'colors' => $colors,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'product_name' => 'required|string|max:255',
                'product_price' => 'required|numeric',
                'category' => 'required',
                'brand' => 'required',
                'images_product' => 'required|min:1',
                'images_product.*' => 'image|max:2048',
                'product_content' => 'required',
                'color_selector' => 'required|min:1',
                'describe' => 'required',
            ],
            [
                'required' => ':attribute không được để trống.',
                'numeric' => ':attribute phải là số.',
                'min' => ':attribute phải chọn ít nhất :min phần tử.',
            ],
            [
                'product_name' => 'Tên sản phẩm',
                'product_price' => 'Giá sản phẩm',
                'category' => 'Danh mục',
                'brand' => 'Thương hiệu',
                'images_product' => 'Hình ảnh sản phẩm',
                'product_content' => 'Chi tiết sản phẩm',
                'describe' => 'Mô tả sản phẩm',
                'color_selector' => 'Màu sản phẩm',
            ]
        );
        if ($request->hasFile('images_product')) {
            $thumbnail = $request->file('images_product');
            $thumbnailName = $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('images/products'), $thumbnailName);
        }
        $data = [
            'product_name' => $request->input('product_name'),
            'slug' =>Str::slug($request->input('product_name')),
            'product_price' => $request->input('product_price'),
            'category_id' => $request->input('category'),
            'brand_id' => $request->input('brand'),
            'describe' => $request->input('describe'),
            'product_content' => $request->input('product_content'),
            'status' => $request->input('status'),
            'created_at' => now(),
        ];
        if (isset($thumbnailName)) {
            $data['thumbnail_path'] = 'images/products/' . $thumbnailName;
        }
        
        $product = Product::create($data);
        $colors = $request->input('color_selector');
        $product->colors()->sync($colors);
        return redirect()->route('admin.product.list')->with('success', 'Sản phẩm đã được thêm thành công!');
    }
    function update(Request $request, $id)
    {
        $product = Product::find($id);
        $oldThumbnailPath = $product->thumbnail_path;
        $request->validate(
            [
                'product_name' => 'required|string|max:255',
                'product_price' => 'required|numeric',
                'category' => 'required',
                'brand' => 'required',
                'images_product.*' => 'image|max:2048',
                'product_content' => 'required',
                'color_selector' => 'required|min:1',
                'describe' => 'required',
            ],
            [
                'required' => ':attribute không được để trống.',
                'numeric' => ':attribute phải là số.',
                'min' => ':attribute phải chọn ít nhất :min phần tử.',
            ],
            [
                'product_name' => 'Tên sản phẩm',
                'product_price' => 'Giá sản phẩm',
                'category' => 'Danh mục',
                'brand' => 'Thương hiệu',
                'images_product.*' => 'Hình ảnh sản phẩm',
                'product_content' => 'Chi tiết sản phẩm',
                'describe' => 'Mô tả sản phẩm',
                'color_selector' => 'Màu sản phẩm',
            ]
        );
        if ($request->hasFile('images_product')) {
            $thumbnail = $request->file('images_product');
            $thumbnailName = $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('images/products'), $thumbnailName);
        }
        $data = [
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'slug' =>Str::slug($request->input('product_name')),
            'category_id' => $request->input('category'),
            'brand_id' => $request->input('brand'),
            'describe' => $request->input('describe'),
            'product_content' => $request->input('product_content'),
            'status' => $request->input('status'),
            'updated_at' => now(),
        ];
        if (isset($thumbnailName)) {
            $data['thumbnail_path'] = 'images/products/' . $thumbnailName;
        } else {
            $data['thumbnail_path'] = $oldThumbnailPath;
        }
        Product::where('id', $id)->update($data);
        $colors = $request->input('color_selector');
        $product->colors()->sync($colors);
        return redirect()->route('admin.product.list')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }
    function deleteProduct($id)
    {
        $products = Product::find($id);
        $products->delete();
        return redirect()->route('admin.product.list')->with('success', 'Sản phẩm đã được xoá thành công!');
    }
    function add_img($id)
    {
        $products = Product::find($id);
        $colors = ColorProduct::pluck('color_name', 'id')->toArray();
        $product_images = ProductImage::all();
        return view('admin.product.add_img', compact('products', 'colors', 'product_images'));
    }
    function update_img(Request $request, $id)
    {
        $products = Product::find($id);
        $request->validate(
            [
                'file-product' => 'required|max:2048',
            ],
            [
                'required' => ':attribute không được để trống.',
                'file-product.required' => 'Hình ảnh sản phẩm không được để trống.',
                'file-product.max' => 'Hình ảnh sản phẩm không được vượt quá kích thước 2MB.',
            ],
            [
                'file-product' => 'Hình ảnh sản phẩm',
            ]
        );
        $file = $request->file('file-product');
        $filename  = $file->getClientOriginalName();
        $file->move(public_path('images/products'), $filename);

        $productImage = new ProductImage();
        $productImage->product_id = $products->id;
        $productImage->image_url = 'images/products/' . $filename;
        $productImage->save();
        return redirect()->route('admin.product.add_img', ['id' => $products->id])->with('success', 'Hình ảnh sản phẩm đã được thêm thành công!');
    }
    function delete_img($id)
    {
        $productImage = ProductImage::find($id);
        if (!$productImage) {
            return redirect()->back()->with('error', 'Hình ảnh sản phẩm không tồn tại!');
        }
        $productId = $productImage->product_id;
        $productImage->delete();
        return redirect()->route('admin.product.add_img', ['id' => $productId])->with('success', 'Hình ảnh sản phẩm đã được xoá thành công!');
    }
    function cat()
    {
        $cat_products = DB::table('cat_products')->get();
        return view('admin.product.cat', compact('cat_products'));
    }
    function deleteCat($id)
    {
        $cat_products = CatProduct::find($id);
        $cat_products->delete();
        return redirect()->route('admin.product.cat')->with('success', 'Danh mục đã được xoá thành công!');
    }
    function storeCat(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'parent_cat' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tiêu đề',
                'parent_cat' => 'Danh mục'
            ]

        );
        try {
            $data = [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'parent_cat' => $request->input('parent_cat'),
                'created_at' => now()
            ];
            DB::table('cat_products')->insert($data);
            return redirect()->route('admin.product.cat')->with('success', 'Danh mục đã được thêm thành công!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('admin.product.cat')->with('error', 'Lỗi: Danh mục đã tồn tại!');
            } else {
                return redirect()->route('admin.product.cat')->with('error', 'Lỗi: Không thể thêm danh mục!');
            }
        }
    }
    function editCat($id)
    {
        $cat_products = DB::table('cat_products')->get();
        $cat = CatProduct::find($id);
        return view('admin.product.editCat', compact('cat_products', 'cat'));
    }
    function updateCat(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'parent_cat' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tiêu đề',
                'parent_cat' => 'Danh mục'
            ]
        );
        CatProduct::where('id', $id)->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'parent_cat' => $request->input('parent_cat'),
            'created_at' => now()
        ]);

        return redirect('admin/product/cat')->with('success', "Đã cập nhập thông tin thành công");
    }
    function listBrand()
    {
        $brands = DB::table('brand_products')->get();
        return view('admin.product.brand', compact('brands'));
    }
    function storeBrand(Request $request)
    {

        $request->validate(
            [
                'name' => 'required',
                'file-brand' => 'required|max:2048',
            ],
            [
                'required' => ':attribute không được để trống',
                'file-brand.max' => 'Hình ảnh sản phẩm không được vượt quá kích thước 2MB.',
            ],
            [
                'name' => 'Tên thương hiệu',
                'file-brand' => 'Hình ảnh thương hiệu',
            ]

        );
        $file = $request->file('file-brand');
        $filename  = $file->getClientOriginalName();
        $file->move(public_path('images/brands'), $filename);
        try {
            $data = [
                'name' => $request->input('name'),
                'logo_path' => 'images/brands/' . $filename,
                'slug' => $request->input('slug'),
                'created_at' => now()
            ];
            DB::table('brand_products')->insert($data);
            return redirect()->route('admin.product.listBrand')->with('success', 'Thương hiệu đã được thêm thành công!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('admin.product.listBrand')->with('error', 'Lỗi: Thương hiệu đã tồn tại!');
            } else {
                return redirect()->route('admin.product.listBrand')->with('error', 'Lỗi: Không thể thêm thương hiệu!');
            }
        }
    }
    function deleteBrand($id)
    {
        $brands = BrandProduct::find($id);
        $brands->delete();
        return redirect()->route('admin.product.listBrand')->with('success', 'Thương hiệu đã được xoá thành công!');
    }
    function editBrand($id)
    {
        $brands = DB::table('brand_products')->get();
        $brand_product = BrandProduct::find($id);
        return view('admin.product.editBrand', compact('brand_product', 'brands'));
    }
    function updateBrand(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên thương hiệu',
            ]
        );
        $brand = BrandProduct::findOrFail($id); 

        if ($request->hasFile('file-brand')) {
            $file = $request->file('file-brand');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('images/brands'), $filename); // Move the uploaded image to the 'public/images/brands' directory
            $brand->logo_path = 'images/brands/' . $filename; // Update the logo path if a new image is uploaded
        }
        try {
            BrandProduct::where('id', $id)->update([
                'name' => $request->input('name'),
                $brand->slug = Str::slug($request->input('slug')),
                $brand->updated_at = now(),
                $brand->save()
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('admin.product.listBrand')->with('error', 'Lỗi: Thương hiệu đã tồn tại!');
            } 
        }
        return redirect('admin/product/product-brand/list')->with('success', "Đã cập nhập thương hiệu thành công");
    }
    function listColor()
    {
        $colors = DB::table('color_products')->paginate(10);
        return view('admin.product.listColor', compact('colors'));
    }
    function add_color(Request $request)
    {

        $request->validate(
            [
                'color_name' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'color_name' => 'Tên màu',
            ]

        );
        $data = [
            'color_name' => $request->input('color_name'),
            'color_code' => $request->input('color_code_hidden'),
            'created_at' => now()
        ];
        DB::table('color_products')->insert($data);
        return redirect()->route('admin.product.listColor')->with('success', 'Màu đã được thêm thành công!');
    }
    function deleteColor($id)
    {
        $colors = ColorProduct::find($id);
        $colors->delete();
        return redirect()->route('admin.product.listColor')->with('success', 'Màu đã được xoá thành công!');
    }
}
