<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CatProduct;
use App\Models\BrandProduct;
use App\Models\Product;
use App\Models\Slider;
use Gloudemans\Shoppingcart\Facades\Cart;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($slug = null,Request $request)
    {
        $cat_products = CatProduct::all();
        $brandsWithProducts = BrandProduct::with('products')->get();
        $products = Product::where('status', 'Còn hàng')->orderBy('created_at', 'desc')->get();
        $sliders = Slider::orderBy('position')->get();
        $cat = Cart::content();
        return view('welcome', compact('cat_products', 'brandsWithProducts', 'products','sliders','cat'));
    }
    
    function regis(Request $request)
    {
        $cat = Cart::content();
        $cat_products = CatProduct::all();
        $brandsWithProducts = BrandProduct::with('products')->get();
        $products = Product::all();
        $request->validate(
            [
                'email' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'email' => 'Email',
            ]

        );
        return view('regis', compact('cat_products', 'brandsWithProducts', 'products','cat'));
    }
    public function ajaxSearch() {
        $data = Product::search()->get();
        return view('search',compact('data'));
    }
}
