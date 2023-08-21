<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CatProduct;
use App\Models\BrandProduct;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
class ProductController extends Controller
{
    public function showProductBySlug(Request $request, $slug)
    {
        $category = CatProduct::where('slug', $slug)->first();
        if (!$category) {
            return abort(404);
        }
        $brandSlug = $request->query('brand');
        $filteredProductsQuery = Product::where('category_id', $category->id);
        $filteredProductsQuery->where('status', 'Còn hàng');
        if ($brandSlug) {
            $filteredProductsQuery->whereHas('brands', function ($query) use ($brandSlug) {
                $query->where('slug', $brandSlug);
            });
        }
        $filter = $request->query('filter');
        if ($filter) {
            switch ($filter) {
                case 'duoi1tr':
                    $filteredProductsQuery->where('product_price', '<', 1000000);
                    break;
                case 'tu1den5tr':
                    $filteredProductsQuery->whereBetween('product_price', [1000000, 5000000]);
                    break;
                case 'tu5den10tr':
                    $filteredProductsQuery->whereBetween('product_price', [5000000, 10000000]);
                    break;
                case 'tu10den20tr':
                    $filteredProductsQuery->whereBetween('product_price', [10000000, 20000000]);
                    break;
                case 'tren20tr':
                    $filteredProductsQuery->where('product_price', '>', 20000000);
                    break;
            }
        }
        $soft = $request->query('soft');
        if ($soft) {
            switch ($soft) {
                case 'asc':
                    $filteredProductsQuery->orderBy('product_name', 'asc');
                    break;
                case 'desc':
                    $filteredProductsQuery->orderBy('product_name', 'desc');
                    break;
                case 'tangdan':
                    $filteredProductsQuery->orderBy('product_price', 'asc');
                    break;
                case 'giamdan':
                    $filteredProductsQuery->orderBy('product_price', 'desc');
                    break;
            }
        }
        $filteredProducts = $filteredProductsQuery->get();
        $cat_products = CatProduct::all();
        $brandsWithProducts = BrandProduct::with('products')->get();
        $products = Product::all();
        $cat = Cart::content();
        return view('product.productBySlug', compact('filteredProducts', 'category', 'cat_products', 'brandsWithProducts', 'products','cat'));
    }
    function showDetailProduct($slug){
        $cat_products = CatProduct::all();
        $cat = Cart::content();
        $brandsWithProducts = BrandProduct::with('products')->get();
        $products = Product::all();
        $product = Product::where('slug', $slug)->first();
        $productColors = $product->colors;
        if (!$product) {
            abort(404);
        }
        $category = $product->category;
        $product_images = $product->images;
        return view('product.detailProduct', compact('cat_products', 'brandsWithProducts', 'products', 'category', 'product','product_images','productColors','cat'));
    }

}
