<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\CatPost;
use App\Models\CatProduct;
use App\Models\BrandProduct;
use App\Models\Post;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
class PageController extends Controller
{
    public function showPageBySlug($slug)
    {
        $page = Page::where('slug', $slug)->first();
        $cat_products = CatProduct::all();
        $brandsWithProducts = BrandProduct::with('products')->get();
        $products = Product::all();
        $cat = Cart::content();
        if (!$page) {
            return abort(404);
        }
        if ($slug === 'lien-he') {

            return view('page.contact', compact('page', 'cat_products', 'brandsWithProducts', 'products','cat'));
        }
        if ($slug === 'gioi-thieu') {
            return view('page.about', compact('page', 'cat_products', 'brandsWithProducts', 'products','cat'));
        }
        if ($slug === 'tin-tuc') {
            $productNew = 'Sản phẩm mới';
            $promotion = 'Khuyến mãi';
            $productCategory = CatPost::where('name', $productNew)->first();
            $promotionCategory = CatPost::where('name', $promotion)->first();
            if ($productCategory && $promotionCategory) {
                $products = $productCategory->posts;
                $promotions = $promotionCategory->posts;

                return view('page.new', compact('products', 'promotions', 'productNew', 'promotion', 'cat_products', 'brandsWithProducts', 'products','cat'));
            }
        }
        return view('page', ['page' => $page]);
    }
    public function showNewsArticle($slug)
    {
        $cat_products = CatProduct::all();
        $brandsWithProducts = BrandProduct::with('products')->get();
        $products = Product::all();
        $newsArticle = Post::where('slug', $slug)->first();
        $cat = Cart::content();
        if (!$newsArticle) {
            return abort(404);
        }
        $productNew = 'Sản phẩm mới';
        $promotion = 'Khuyến mãi';
        $productCategory = CatPost::where('name', $productNew)->first();
        $promotionCategory = CatPost::where('name', $promotion)->first();
        if ($productCategory  && $promotionCategory) {
            $products = $productCategory->posts;
            $promotions = $promotionCategory->posts;
        }
        return view('page.news_article', compact('newsArticle', 'products', 'promotions', 'cat_products', 'brandsWithProducts', 'products','cat'));
    }
    function store(Request $request)
    {
        $cat = Cart::content();
        $cat_products = CatProduct::all();
        $brandsWithProducts = BrandProduct::with('products')->get();
        $products = Product::all();
        $request->validate(
            [
                'fullname' => 'required',
                'email' => 'required',
                'phone' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'fullname' => 'Họ tên',
                'email' => 'Email',
                'phone' => 'Số điện thoại'
            ]

        );
        return view('page.notification', compact('cat_products', 'brandsWithProducts', 'products','cat'));
    }
}
